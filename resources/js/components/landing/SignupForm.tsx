import React, { useState } from 'react';
import { motion } from 'framer-motion';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Send, CheckCircle, Loader2, Sparkles } from 'lucide-react';
import { router } from '@inertiajs/react';

export default function SignupForm() {
    const [formData, setFormData] = useState({ name: '', email: '' });
    const [isSubmitting, setIsSubmitting] = useState(false);
    const [isSuccess, setIsSuccess] = useState(false);
    const [error, setError] = useState('');

    const handleSubmit = async (e: { preventDefault: () => void }) => {
        e.preventDefault();
        setError('');

        if (!formData.name.trim() || !formData.email.trim()) {
            setError('Please fill in all fields');
            return;
        }

        if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(formData.email)) {
            setError('Please enter a valid email address');
            return;
        }

        setIsSubmitting(true);

        const name = formData.name;
        const email = formData.email;

        // Encode the values to handle special characters
        const encodedName = encodeURIComponent(name);
        const encodedEmail = encodeURIComponent(email);

        // Use Inertia's post method with data
        router.post(`/send-ebook/${encodedName}/${encodedEmail}`, formData, {
            preserveScroll: true,
            preserveState: true,
            onSuccess: () => {
                setIsSuccess(true);
                setIsSubmitting(false);
                return;
            },
            onError: (errors) => {
                setError(errors?.message || 'Something went wrong');
                setIsSubmitting(false);
                return;
            },
        });

    };

    if (isSuccess) {
        return (
            <section id="signup-form" className="py-24 md:py-32 bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900">
                <div className="max-w-xl mx-auto px-6">
                    <motion.div
                        className="bg-white/5 backdrop-blur-sm border border-white/10 rounded-3xl p-10 md:p-12 text-center"
                        initial={{ opacity: 0, scale: 0.95 }}
                        animate={{ opacity: 1, scale: 1 }}
                        transition={{ duration: 0.5 }}
                    >
                        <motion.div
                            initial={{ scale: 0 }}
                            animate={{ scale: 1 }}
                            transition={{ type: "spring", duration: 0.6 }}
                        >
                            <div className="w-20 h-20 bg-green-500/20 rounded-full flex items-center justify-center mx-auto">
                                <CheckCircle className="w-10 h-10 text-green-400" />
                            </div>
                        </motion.div>
                        <h3 className="mt-8 text-2xl md:text-3xl font-semibold text-white">
                            Check your inbox!
                        </h3>
                        <p className="mt-4 text-slate-400 leading-relaxed">
                            We've sent the ebook to <span className="text-amber-400">{formData.email}</span>.
                            If you don't see it, check your spam folder.
                        </p>
                    </motion.div>
                </div>
            </section>
        );
    }

    return (
        <section id="signup-form" className="py-24 md:py-32 bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900 relative overflow-hidden">
            {/* Background effects */}
            <div className="absolute inset-0">
                <motion.div
                    className="absolute top-0 right-0 w-96 h-96 bg-amber-500/10 rounded-full blur-3xl"
                    animate={{ scale: [1, 1.1, 1], opacity: [0.3, 0.4, 0.3] }}
                    transition={{ duration: 8, repeat: Infinity }}
                />
                <motion.div
                    className="absolute bottom-0 left-0 w-80 h-80 bg-blue-500/10 rounded-full blur-3xl"
                    animate={{ scale: [1.1, 1, 1.1], opacity: [0.3, 0.4, 0.3] }}
                    transition={{ duration: 10, repeat: Infinity }}
                />
            </div>

            <div className="relative z-10 max-w-xl mx-auto px-6">
                <motion.div
                    className="text-center mb-12"
                    initial={{ opacity: 0, y: 30 }}
                    whileInView={{ opacity: 1, y: 0 }}
                    viewport={{ once: true }}
                    transition={{ duration: 0.8 }}
                >
                    <div className="inline-flex items-center gap-2 px-4 py-2 bg-amber-500/10 rounded-full border border-amber-500/20 mb-6">
                        <Sparkles className="w-4 h-4 text-amber-400" />
                        <span className="text-sm text-amber-400 font-medium">100% Free, No Spam</span>
                    </div>
                    <h2 className="text-3xl md:text-4xl font-light text-white leading-tight">
                        Get your free copy
                        <span className="block font-semibold text-amber-400">instantly</span>
                    </h2>
                    <p className="mt-4 text-slate-400">
                        Enter your details and we'll send it straight to your inbox.
                    </p>
                </motion.div>

                <motion.div
                    className="bg-white/5 backdrop-blur-sm border border-white/10 rounded-3xl p-8 md:p-10"
                    initial={{ opacity: 0, y: 30 }}
                    whileInView={{ opacity: 1, y: 0 }}
                    viewport={{ once: true }}
                    transition={{ duration: 0.8, delay: 0.1 }}
                >
                    <form onSubmit={handleSubmit} className="space-y-5">
                    {/*<form className="space-y-5">*/}
                        <div>
                            <label className="block text-sm font-medium text-slate-300 mb-2">
                                Your Name
                            </label>
                            <Input
                                type="text"
                                placeholder="John Smith"
                                value={formData.name}
                                onChange={(e) => setFormData({ ...formData, name: e.target.value })}
                                className="h-12 bg-white/5 border-white/10 text-white placeholder:text-slate-500 focus:border-amber-500/50 focus:ring-amber-500/20"
                            />
                        </div>
                        <div>
                            <label className="block text-sm font-medium text-slate-300 mb-2">
                                Email Address
                            </label>
                            <Input
                                type="email"
                                placeholder="john@example.com"
                                value={formData.email}
                                onChange={(e) => setFormData({ ...formData, email: e.target.value })}
                                className="h-12 bg-white/5 border-white/10 text-white placeholder:text-slate-500 focus:border-amber-500/50 focus:ring-amber-500/20"
                            />
                        </div>

                        {error && (
                            <motion.p
                                className="text-red-400 text-sm"
                                initial={{ opacity: 0 }}
                                animate={{ opacity: 1 }}
                            >
                                {error}
                            </motion.p>
                        )}

                        <Button
                            type="submit"
                            disabled={isSubmitting}
                            className="w-full h-12 bg-gradient-to-r from-amber-500 to-amber-600 hover:from-amber-400 hover:to-amber-500 text-slate-900 font-medium rounded-xl transition-all duration-300 shadow-lg shadow-amber-500/25"
                        >
                            {isSubmitting ? (
                                <>
                                    <Loader2 className="w-4 h-4 mr-2 animate-spin" />
                                    Sending...
                                </>
                            ) : (
                                <>
                                    <Send className="w-4 h-4 mr-2" />
                                    Send Me the Ebook
                                </>
                            )}
                        </Button>
                    </form>

                    <p className="mt-6 text-center text-xs text-slate-500">
                        By submitting, you agree to receive emails from us. Unsubscribe anytime.
                    </p>
                </motion.div>
            </div>
        </section>
    );
}
