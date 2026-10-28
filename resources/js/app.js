
import React from 'react';
import { createRoot } from 'react-dom/client';
import '../css/app.css';

function App() {
    return (
        <div>
            <h1>Fence Admin</h1>
            <p>Welcome to your fence business website!</p>
        </div>
    );
}

createRoot(document.getElementById('app')).render(<App />);
