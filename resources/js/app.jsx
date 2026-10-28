
import React, { useEffect, useState } from 'react';
import { createRoot } from 'react-dom/client';
import '../css/app.css';

function App() {
    const [data, setData] = useState(null);
    const [error, setError] = useState('');
    const [menuOpen, setMenuOpen] = useState(false);

    useEffect(() => {
        fetch('/home-data')
            .then((response) => {
                if (!response.ok) {
                    throw new Error('Could not load homepage data.');
                }
                return response.json();
            })
            .then((result) => {
                setData(result);
            })
            .catch(() => {
                setError(
                    'Homepage data load nahi hua. Laravel server aur database check karein.'
                );
            });
    }, []);

    if (error) {
        return <div className="loading-message">{error}</div>;
    }

    if (!data) {
        return <div className="loading-message">Loading website...</div>;
    }

    const settings = data.settings;
    const services = data.services || [];
    const categories = data.categories || [];
    const products = data.products || [];

    // Uploaded logo ka public URL
    const logoUrl = settings.logo_path
        ? `/storage/${settings.logo_path}`
        : null;

    // Navbar aur footer ke liye reusable brand
    const Brand = ({ light = false }) => (
        <a
            className={`brand${light ? ' brand-light' : ''}`}
            href="#home"
            aria-label={`${settings.brand_name} homepage`}
        >
            {logoUrl ? (
                <img
                    className="brand-logo"
                    src={logoUrl}
                    alt={`${settings.brand_name} logo`}
                />
            ) : (
                <span className="brand-icon">
                    {(settings.brand_name || 'B').charAt(0).toUpperCase()}
                </span>
            )}

            <span>{settings.brand_name}</span>
        </a>
    );

    return (
        <>
            <div className="topbar">
                Professional fencing solutions for your property
                <a href="#contact">Get a free quote →</a>
            </div>

            <header className="navbar">
                <Brand />

                <button
                    className="menu-toggle"
                    onClick={() => setMenuOpen(!menuOpen)}
                    aria-label="Toggle navigation"
                    aria-expanded={menuOpen}
                >
                    ☰
                </button>

                <nav className={menuOpen ? 'nav-links open' : 'nav-links'}>
                    <a href="#home" onClick={() => setMenuOpen(false)}>
                        Home
                    </a>
                    <a href="#services" onClick={() => setMenuOpen(false)}>
                        Services
                    </a>
                    <a href="#products" onClick={() => setMenuOpen(false)}>
    Products
</a>
                    <a href="#about" onClick={() => setMenuOpen(false)}>
                        About Us
                    </a>
                    <a href="#contact" onClick={() => setMenuOpen(false)}>
                        Contact
                    </a>
                    <a
                        className="nav-cta"
                        href="#contact"
                        onClick={() => setMenuOpen(false)}
                    >
                        Get a Quote
                    </a>
                </nav>
            </header>

            <main>
                <section
                    className="hero"
                    id="home"
                   
style={{
    backgroundImage: `linear-gradient(90deg, rgba(13, 32, 24, .88), rgba(13, 32, 24, .36)), url("${settings.hero_image_path ? `/storage/${settings.hero_image_path}` : settings.hero_image_url || ''}")`
}}

                >
                    <div className="hero-content">
                        <span className="eyebrow">
                            YOUR PROPERTY. OUR PRIORITY.
                        </span>

                        <h1>{settings.hero_title}</h1>
                        <p>{settings.hero_subtitle}</p>

<div className="hero-actions">
    <a
        className="button button-primary"
        href={settings.hero_primary_button_url || '#contact'}
    >
        {settings.hero_primary_button_text || 'Request a Free Quote'}
        <span>→</span>
    </a>

    <a
        className="button button-outline"
        href={settings.hero_secondary_button_url || '#services'}
    >
        {settings.hero_secondary_button_text || 'Explore Our Services'}
    </a>
</div>


                        <div className="hero-note">
                            <span className="note-check">✓</span>
                            Quality-focused service. Solutions built for you.
                        </div>
                    </div>
                </section>

               
<section className="trust-strip">
    {[1, 2, 3].map((number) => {
        const value = settings[`stat_${number}_value`];
        const label = settings[`stat_${number}_label`];

        const defaultStats = {
            1: { value: '500+', label: 'Products' },
            2: { value: '50+', label: 'Countries' },
            3: { value: '10,000+', label: 'Happy Clients' },
        };

        const stat = defaultStats[number];

        return (
            <div key={number}>
                <strong>{value || stat.value}</strong>
                <span>{label || stat.label}</span>
            </div>
        );
    })}
</section>


                <section className="section services-section" id="services">
                    <div className="section-heading">
                        <span className="eyebrow">WHAT WE DO</span>
                        <h2>Fencing Solutions for Every Need</h2>
                        <p>
                            Explore our services and find the right solution
                            for your property.
                        </p>
                    </div>

                    <div className="service-grid">
                        {services.map((service) => (
                            <article className="service-card" key={service.id}>
                                <div className="service-image">
                                    {service.image_url && (
                                        <img
                                            src={service.image_url}
                                            alt={service.title}
                                            loading="lazy"
                                        />
                                    )}
                                </div>

                                <div className="service-content">
                                    <h3>{service.title}</h3>
                                    <p>{service.description}</p>
                                    <a href="#contact">
                                        Learn more <span>→</span>
                                    </a>
                                </div>
                            </article>
                        ))}
                    </div>
                </section>
                
<section className="section categories-section" id="categories">
    <div className="section-heading">
        <span className="eyebrow">CATEGORIES</span>
        <h2>Fencing Solutions for Every Need</h2>
        <p>Complete fencing and livestock solutions for every need.</p>
    </div>

    <div className="category-grid">
        {categories.map((category) => (
            <article className="category-card" key={category.id}>
                <div className="category-image">
                    {category.image_path ? (
                        <img
                            src={`/storage/${category.image_path}`}
                            alt={category.name}
                            loading="lazy"
                        />
                    ) : (
                        <div className="category-no-image">
                            {category.name}
                        </div>
                    )}
                </div>

                <div className="category-content">
                    <h3>{category.name}</h3>

                    <p>
                        {category.description ||
                            'Explore our range of quality products.'}
                    </p>

                    <span className="category-count">
                        {category.products_count}{' '}
                        {category.products_count === 1 ? 'Product' : 'Products'}
                    </span>
                </div>
            </article>
        ))}
    </div>
</section>

<section className="section products-section" id="products">
    <div className="section-heading">
        <span className="eyebrow">OUR PRODUCTS</span>
        <h2>Explore Our Products</h2>
        <p>Discover our available products and their prices.</p>
    </div>

    <div className="product-grid">
        {products.length > 0 ? (
            products.map((product) => (
                <article className="product-card" key={product.id}>
                    <div className="product-image">
                        {product.image_path ? (
                            <img
                                src={`/storage/${product.image_path}`}
                                alt={product.name}
                                loading="lazy"
                            />
                        ) : (
                            <div className="product-no-image">
                                No image available
                            </div>
                        )}
                    </div>
{product.category && (
    <span className="product-category">
        {product.category.name}
    </span>
)}
                    <div className="product-content">
                        <h3>{product.name}</h3>

                        <p>
                            {product.description ||
                                'Contact us for more details.'}
                        </p>

                        <strong className="product-price">
                            {Number(product.price).toLocaleString('en-PK', {
                                style: 'currency',
                                currency: 'PKR',
                                maximumFractionDigits: 2,
                            })}
                        </strong>
                    </div>
                </article>
            ))
        ) : (
            <p>No products available at the moment.</p>
        )}
    </div>
</section>


                <section className="about-section" id="about">
                    <div className="about-visual">
                        <div className="about-image"></div>

                        <div className="about-caption">
                            <span className="caption-mark">✓</span>
                            <div>
                                <strong>Made for your property</strong>
                                <span>Solutions with care and attention</span>
                            </div>
                        </div>
                    </div>

                    <div className="about-content">
                        <span className="eyebrow">ABOUT OUR COMPANY</span>
                        <h2>{settings.about_title}</h2>
                        <p>{settings.about_text}</p>

                        <ul>
                            <li>Solutions tailored to your needs</li>
                            <li>
                                Clear communication throughout your project
                            </li>
                            <li>Attention to quality and detail</li>
                        </ul>

                        <a className="button button-dark" href="#contact">
                            Talk to Our Team →
                        </a>
                    </div>
                </section>

                <section className="quote-banner" id="contact">
                    <div>
                        <span className="eyebrow">LET'S GET STARTED</span>
                        <h2>Ready to Plan Your Fence?</h2>
                        <p>
                            Contact our team to discuss your project and
                            request a quote.
                        </p>
                    </div>

                    <div className="quote-contact">
                        <a
                            className="button button-primary"
                            href={
                                settings.email
                                    ? `mailto:${settings.email}`
                                    : '#contact'
                            }
                        >
                            Contact Us <span>→</span>
                        </a>
                        <span>{settings.phone}</span>
                    </div>
                </section>
            </main>

            <footer className="footer">
                <div className="footer-main">
                    <div className="footer-brand">
                        <Brand light />
                        <p>{settings.tagline}</p>
                    </div>

                    <div>
                        <h4>Explore</h4>
                        <a href="#home">Home</a>
                        <a href="#services">Services</a>
                        <a href="#about">About Us</a>
                    </div>

                    <div>
                        <h4>Contact</h4>
                        <p>{settings.phone}</p>
                        <p>{settings.email}</p>
                        <p>{settings.address}</p>
                    </div>
                </div>

                <div className="footer-bottom">
                    <span>
                        © {new Date().getFullYear()} {settings.brand_name}.
                        All rights reserved.
                    </span>
                    <a href="#home">Back to top ↑</a>
                </div>
            </footer>
        </>
    );
}

createRoot(document.getElementById('app')).render(<App />);
