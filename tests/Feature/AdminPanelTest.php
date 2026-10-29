<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AdminPanelTest extends TestCase
{
    use RefreshDatabase;

    private function admin(): User
    {
        return User::factory()->admin()->create();
    }

    // ---- Authentication -------------------------------------------------

    public function test_login_page_renders_with_password_toggle(): void
    {
        $this->get('/admin/login')
            ->assertOk()
            ->assertSee('Admin Login')
            ->assertSee('name="email"', false)
            ->assertSee('id="toggle-password"', false);
    }

    public function test_admin_can_log_in_and_reach_the_dashboard(): void
    {
        $admin = User::factory()->admin()->create(['password' => 'correct-password']);

        $this->post('/admin/login', ['email' => $admin->email, 'password' => 'correct-password'])
            ->assertRedirect('/admin');

        $this->assertAuthenticatedAs($admin);
        $this->get('/admin')->assertOk()->assertSee('Dashboard Overview');
    }

    public function test_wrong_password_is_rejected(): void
    {
        $admin = $this->admin();

        $this->from('/admin/login')
            ->post('/admin/login', ['email' => $admin->email, 'password' => 'wrong'])
            ->assertRedirect('/admin/login')
            ->assertSessionHasErrors('email');

        $this->assertGuest();
    }

    public function test_non_admin_user_cannot_log_in_to_admin_area(): void
    {
        $user = User::factory()->create(['password' => 'correct-password']);

        $this->from('/admin/login')
            ->post('/admin/login', ['email' => $user->email, 'password' => 'correct-password'])
            ->assertSessionHasErrors('email');

        $this->assertGuest();
    }

    public function test_login_requires_email_and_password(): void
    {
        $this->post('/admin/login', [])->assertSessionHasErrors(['email', 'password']);
    }

    public function test_login_is_throttled(): void
    {
        for ($i = 0; $i < 5; $i++) {
            $this->post('/admin/login', ['email' => 'a@b.test', 'password' => 'x']);
        }

        $this->post('/admin/login', ['email' => 'a@b.test', 'password' => 'x'])->assertStatus(429);
    }

    public function test_admin_can_log_out(): void
    {
        $this->actingAs($this->admin())
            ->post('/admin/logout')
            ->assertRedirect('/admin/login');

        $this->assertGuest();
    }

    // ---- Authorization --------------------------------------------------

    public function test_guests_are_redirected_to_login_from_every_admin_page(): void
    {
        foreach ([
            '/admin',
            '/admin/website-content',
            '/admin/categories',
            '/admin/categories/create',
            '/admin/products',
            '/admin/products/create',
            '/admin/register',
        ] as $url) {
            $this->get($url)->assertRedirect(route('admin.login'));
        }
    }

    public function test_guests_cannot_change_data(): void
    {
        $this->post('/admin/products', ['name' => 'x', 'price' => 1])->assertRedirect(route('admin.login'));
        $this->post('/admin/categories', ['name' => 'x'])->assertRedirect(route('admin.login'));
        $this->post('/admin/register', [])->assertRedirect(route('admin.login'));
        $this->assertDatabaseCount('products', 0);
    }

    public function test_non_admin_users_get_403_on_admin_pages(): void
    {
        $user = User::factory()->create();

        foreach (['/admin', '/admin/products', '/admin/categories', '/admin/website-content', '/admin/register'] as $url) {
            $this->actingAs($user)->get($url)->assertForbidden();
        }

        $this->actingAs($user)->post('/admin/products', ['name' => 'x', 'price' => 1])->assertForbidden();
        $this->assertDatabaseCount('products', 0);
    }

    // ---- Admin creation -------------------------------------------------

    public function test_admin_can_create_another_admin_with_hashed_password(): void
    {
        $this->actingAs($this->admin())
            ->post('/admin/register', [
                'name' => 'Second Admin',
                'email' => 'second@example.test',
                'password' => 'long-enough-pass',
                'password_confirmation' => 'long-enough-pass',
            ])
            ->assertRedirect('/admin');

        $created = User::where('email', 'second@example.test')->firstOrFail();
        $this->assertTrue($created->is_admin);
        $this->assertNotSame('long-enough-pass', $created->password);
        $this->assertTrue(password_verify('long-enough-pass', $created->password));
    }

    public function test_admin_registration_validates_input(): void
    {
        $this->actingAs($this->admin())
            ->post('/admin/register', [
                'name' => 'x', 'email' => 'bad', 'password' => 'short', 'password_confirmation' => 'other',
            ])
            ->assertSessionHasErrors(['email', 'password']);
    }

    public function test_artisan_command_creates_admin(): void
    {
        $this->artisan('admin:create', [
            '--name' => 'Boss',
            '--email' => 'boss@example.test',
            '--password' => 'super-secret-1',
        ])->assertSuccessful();

        $user = User::where('email', 'boss@example.test')->firstOrFail();
        $this->assertTrue($user->is_admin);
        $this->assertTrue(password_verify('super-secret-1', $user->password));
    }

    public function test_artisan_command_rejects_short_password(): void
    {
        $this->artisan('admin:create', [
            '--name' => 'Boss',
            '--email' => 'boss@example.test',
            '--password' => 'short',
        ])->assertFailed();

        $this->assertDatabaseMissing('users', ['email' => 'boss@example.test']);
    }

    public function test_artisan_command_can_promote_existing_user(): void
    {
        $user = User::factory()->create(['email' => 'staff@example.test']);

        $this->artisan('admin:create', ['--email' => 'staff@example.test'])
            ->expectsConfirmation('A user with staff@example.test already exists. Promote them to admin?', 'yes')
            ->assertSuccessful();

        $this->assertTrue($user->fresh()->is_admin);
    }

    // ---- Dashboard ------------------------------------------------------

    public function test_dashboard_shows_real_counts(): void
    {
        $category = ProductCategory::create(['name' => 'Wire', 'is_active' => true]);
        Product::create(['name' => 'Barbed Wire Roll', 'price' => 10, 'category_id' => $category->id, 'is_active' => true]);
        Product::create(['name' => 'Loose Post', 'price' => 5, 'is_active' => false]);

        $response = $this->actingAs($this->admin())->get('/admin');

        $response->assertOk()
            ->assertSee('Barbed Wire Roll')
            ->assertSee('1 product has no category', false)
            ->assertViewHas('stats', fn (array $stats) => $stats['products'] === 2
                && $stats['active_products'] === 1
                && $stats['categories'] === 1
                && $stats['admins'] === 1);
    }

    public function test_dashboard_shows_empty_state_without_products(): void
    {
        $this->actingAs($this->admin())->get('/admin')->assertOk()->assertSee('No products yet');
    }

    // ---- Products -------------------------------------------------------

    public function test_admin_can_create_update_and_delete_a_product(): void
    {
        Storage::fake('public');
        $admin = $this->admin();
        $category = ProductCategory::create(['name' => 'Posts']);

        $this->actingAs($admin)->post('/admin/products', [
            'name' => 'Steel Post',
            'price' => '19.50',
            'category_id' => $category->id,
            'is_active' => '1',
            // 1x1 PNG; avoids needing the GD extension that fake()->image() uses.
            'image' => UploadedFile::fake()->createWithContent(
                'post.png',
                base64_decode('iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAADUlEQVR42mP8z8BQDwAEhQGAhKmMIQAAAABJRU5ErkJggg==')
            ),
        ])->assertRedirect(route('admin.products.index'));

        $product = Product::where('name', 'Steel Post')->firstOrFail();
        $this->assertTrue($product->is_active);
        Storage::disk('public')->assertExists($product->image_path);

        $this->actingAs($admin)->put("/admin/products/{$product->id}", [
            'name' => 'Steel Post XL',
            'price' => '25',
        ])->assertRedirect(route('admin.products.index'));

        $product->refresh();
        $this->assertSame('Steel Post XL', $product->name);
        $this->assertFalse($product->is_active); // unchecked box

        $this->actingAs($admin)->delete("/admin/products/{$product->id}")
            ->assertRedirect(route('admin.products.index'));

        $this->assertModelMissing($product);
        Storage::disk('public')->assertMissing($product->image_path);
    }

    public function test_product_validation_errors(): void
    {
        $this->actingAs($this->admin())
            ->post('/admin/products', ['name' => '', 'price' => 'abc', 'category_id' => 999])
            ->assertSessionHasErrors(['name', 'price', 'category_id']);
    }

    public function test_product_list_search_filter_and_empty_state(): void
    {
        $admin = $this->admin();
        $category = ProductCategory::create(['name' => 'Wire']);
        Product::create(['name' => 'Barbed Wire', 'price' => 1, 'category_id' => $category->id]);
        Product::create(['name' => 'Gate Hinge', 'price' => 2, 'is_active' => false]);

        $this->actingAs($admin)->get('/admin/products?search=barbed')
            ->assertOk()->assertSee('Barbed Wire')->assertDontSee('Gate Hinge');

        $this->actingAs($admin)->get('/admin/products?status=inactive')
            ->assertOk()->assertSee('Gate Hinge')->assertDontSee('Barbed Wire');

        $this->actingAs($admin)->get("/admin/products?category={$category->id}")
            ->assertOk()->assertSee('Barbed Wire')->assertDontSee('Gate Hinge');

        $this->actingAs($admin)->get('/admin/products?category=none')
            ->assertOk()->assertSee('Gate Hinge')->assertDontSee('Barbed Wire');

        $this->actingAs($admin)->get('/admin/products?search=zzzz')
            ->assertOk()->assertSee('No products match your filters');
    }

    public function test_product_list_is_paginated(): void
    {
        foreach (range(1, 12) as $i) {
            Product::create(['name' => "Item {$i}", 'price' => $i]);
        }

        $this->actingAs($this->admin())->get('/admin/products')
            ->assertOk()->assertSee('Next');
    }

    // ---- Categories -----------------------------------------------------

    public function test_admin_can_manage_categories(): void
    {
        $admin = $this->admin();

        $this->actingAs($admin)->post('/admin/categories', [
            'name' => 'Livestock Fence', 'sort_order' => 2, 'is_active' => '1',
        ])->assertRedirect(route('admin.categories.index'));

        $category = ProductCategory::where('name', 'Livestock Fence')->firstOrFail();

        $this->actingAs($admin)->put("/admin/categories/{$category->id}", ['name' => 'Cattle Fence'])
            ->assertRedirect(route('admin.categories.index'));
        $this->assertSame('Cattle Fence', $category->fresh()->name);

        $this->actingAs($admin)->get('/admin/categories?search=cattle')->assertOk()->assertSee('Cattle Fence');
        $this->actingAs($admin)->get('/admin/categories?status=active')->assertOk()->assertSee('No categories match your filters');

        $this->actingAs($admin)->delete("/admin/categories/{$category->id}")
            ->assertRedirect(route('admin.categories.index'));
        $this->assertModelMissing($category);
    }

    public function test_category_with_products_cannot_be_deleted(): void
    {
        $category = ProductCategory::create(['name' => 'Wire']);
        Product::create(['name' => 'Roll', 'price' => 1, 'category_id' => $category->id]);

        $this->actingAs($this->admin())->delete("/admin/categories/{$category->id}")
            ->assertSessionHas('error');

        $this->assertModelExists($category);
    }

    // ---- Website content & public site ----------------------------------

    public function test_website_content_page_loads_for_admin(): void
    {
        $this->actingAs($this->admin())->get('/admin/website-content')->assertOk();
    }

    public function test_public_homepage_and_data_endpoint_work(): void
    {
        $this->withoutVite();

        $this->get('/')->assertOk();
        $this->getJson('/home-data')->assertOk()->assertJsonStructure(['settings', 'services', 'categories', 'products']);
    }
}
