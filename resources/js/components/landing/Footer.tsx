import React from 'react';

export default function Footer() {
    return (
        <footer className="py-10 bg-slate-900 border-t border-slate-800">
            <div className="max-w-6xl mx-auto px-6 text-center">
                <p className="text-slate-500 text-sm">
                    © {new Date().getFullYear()} Project Management Academy. All rights reserved.
                </p>
            </div>
        </footer>
    );
}
