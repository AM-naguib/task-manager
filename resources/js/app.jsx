import React from 'react';
import ReactDOM from 'react-dom/client';
import AddTask from './components/AddTask';

function App() {
    return (
        <div>
            <AddTask />
        </div>
    );
}

const rootElement = document.getElementById('app');
if (rootElement) {
    ReactDOM.createRoot(rootElement).render(<App />);
}
