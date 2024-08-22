import React from 'react';
import ReactDOM from 'react-dom/client';
import AddTask from '../components/AddTask';

function App() {
    // Function to get the 'id' parameter from the URL
    const getIdFromUrl = () => {
        const urlParams = new URLSearchParams(window.location.search);
        return urlParams.get('id');
    };

    const id = getIdFromUrl(); // Get the id from the URL

    return (
        <div>
            <AddTask taskId={id} />
        </div>
    );
}

const rootElement = document.getElementById('app');
if (rootElement) {
    ReactDOM.createRoot(rootElement).render(<App />);
}