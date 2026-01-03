import React from 'react';
import { motion } from 'framer-motion';
import { BookOpen, FileText, Award, TrendingUp } from 'lucide-react';

const features = [
    {
        icon: FileText,
        title: "120+ Pages",
        description: "Comprehensive content covering every aspect"
    },
    {
        icon: BookOpen,
        title: "Real Case Studies",
        description: "Learn from Fortune 500 project examples"
    },
    {
        icon: Award,
        title: "Templates Included",
        description: "Ready-to-use frameworks and checklists"
    },
    {
        icon: TrendingUp,
        title: "Proven Methods",
        description: "Industry-tested strategies that work"
    }
];

export default function EbookPreview() {
    return (
        <section className="py-24 md:py-32 bg-white">
            <div className="max-w-6xl mx-auto px-6">
                <div className="grid lg:grid-cols-2 gap-16 items-center">
                    {/* Ebook mockup */}
                    <motion.div
                        className="relative"
                        initial={{ opacity: 0, x: -50 }}
                        whileInView={{ opacity: 1, x: 0 }}
                        viewport={{ once: true }}
                        transition={{ duration: 0.8 }}
                    >
                        <div className="relative mx-auto w-72 md:w-80">
                            {/* Shadow */}
                            <div className="absolute -bottom-8 left-1/2 -translate-x-1/2 w-4/5 h-8 bg-black/20 blur-2xl rounded-full" />

                            {/* Book */}
                            <div className="relative bg-gradient-to-br from-slate-800 to-slate-900 rounded-lg shadow-2xl aspect-[3/4] p-8 flex flex-col justify-between">
                                {/* Book spine effect */}
                                <div className="absolute left-0 top-0 bottom-0 w-4 bg-gradient-to-r from-slate-700 to-transparent rounded-l-lg" />

                                <div>
                                    <div className="w-12 h-1 bg-amber-500 mb-6" />
                                    <h3 className="text-xl md:text-2xl font-light text-white leading-tight">
                                        The Complete Guide to
                                    </h3>
                                    <h3 className="text-2xl md:text-3xl font-semibold text-amber-400 mt-2">
                                        Project Management
                                    </h3>
                                </div>

                                <div className="space-y-3">
                                    <div className="h-px bg-slate-700" />
                                    <p className="text-sm text-slate-400 font-light">
                                        From Chaos to Clarity
                                    </p>
                                    <p className="text-xs text-slate-500 tracking-widest uppercase">
                                        2024 Edition
                                    </p>
                                </div>
                            </div>

                            {/* Floating elements */}
                            <motion.div
                                className="absolute -top-6 -right-6 w-16 h-16 bg-amber-500 rounded-xl flex items-center justify-center shadow-lg"
                                animate={{ y: [0, -8, 0] }}
                                transition={{ duration: 3, repeat: Infinity }}
                            >
                                <span className="text-slate-900 font-bold text-sm">FREE</span>
                            </motion.div>
                        </div>
                    </motion.div>

                    {/* Content */}
                    <motion.div
                        initial={{ opacity: 0, x: 50 }}
                        whileInView={{ opacity: 1, x: 0 }}
                        viewport={{ once: true }}
                        transition={{ duration: 0.8 }}
                    >
            <span className="text-sm font-medium tracking-widest text-amber-600 uppercase">
              What's Inside
            </span>
                        <h2 className="mt-4 text-3xl md:text-4xl font-light text-slate-900 leading-tight">
                            Everything you need to
                            <span className="block font-semibold">lead with confidence</span>
                        </h2>
                        <p className="mt-6 text-slate-600 leading-relaxed">
                            This isn't just another generic ebook. It's a carefully crafted resource
                            designed to transform how you approach, plan, and execute projects of any scale.
                        </p>

                        <div className="mt-10 grid sm:grid-cols-2 gap-6">
                            {features.map((feature, index) => (
                                <motion.div
                                    key={index}
                                    className="flex gap-4"
                                    initial={{ opacity: 0, y: 20 }}
                                    whileInView={{ opacity: 1, y: 0 }}
                                    viewport={{ once: true }}
                                    transition={{ duration: 0.5, delay: index * 0.1 }}
                                >
                                    <div className="flex-shrink-0 w-10 h-10 bg-slate-100 rounded-lg flex items-center justify-center">
                                        <feature.icon className="w-5 h-5 text-slate-700" />
                                    </div>
                                    <div>
                                        <h4 className="font-medium text-slate-900">{feature.title}</h4>
                                        <p className="text-sm text-slate-500 mt-1">{feature.description}</p>
                                    </div>
                                </motion.div>
                            ))}
                        </div>
                    </motion.div>
                </div>
            </div>
        </section>
    );
}
