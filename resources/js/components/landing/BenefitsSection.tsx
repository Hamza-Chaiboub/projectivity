import React from 'react';
import { motion } from 'framer-motion';
import { Target, Clock, Users, Lightbulb, BarChart3, Shield } from 'lucide-react';

const benefits = [
    {
        icon: Target,
        title: "Set Clear Goals",
        description: "Learn to define project objectives that align with business outcomes and keep teams focused."
    },
    {
        icon: Clock,
        title: "Master Time Management",
        description: "Discover scheduling techniques that prevent bottlenecks and keep projects on track."
    },
    {
        icon: Users,
        title: "Lead High-Performance Teams",
        description: "Build and motivate teams that consistently deliver exceptional results."
    },
    {
        icon: Lightbulb,
        title: "Solve Problems Creatively",
        description: "Develop frameworks for tackling unexpected challenges with confidence."
    },
    {
        icon: BarChart3,
        title: "Track Progress Effectively",
        description: "Implement metrics and dashboards that provide real visibility into project health."
    },
    {
        icon: Shield,
        title: "Manage Risk Proactively",
        description: "Identify and mitigate risks before they derail your project timeline."
    }
];

export default function BenefitsSection() {
    return (
        <section className="py-24 md:py-32 bg-slate-50">
            <div className="max-w-6xl mx-auto px-6">
                <motion.div
                    className="text-center max-w-2xl mx-auto"
                    initial={{ opacity: 0, y: 30 }}
                    whileInView={{ opacity: 1, y: 0 }}
                    viewport={{ once: true }}
                    transition={{ duration: 0.8 }}
                >
          <span className="text-sm font-medium tracking-widest text-amber-600 uppercase">
            What You'll Learn
          </span>
                    <h2 className="mt-4 text-3xl md:text-4xl font-light text-slate-900 leading-tight">
                        Skills that transform
                        <span className="block font-semibold">your career trajectory</span>
                    </h2>
                    <p className="mt-6 text-slate-600 leading-relaxed">
                        Each chapter is designed to give you actionable insights you can apply immediately.
                    </p>
                </motion.div>

                <div className="mt-16 grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                    {benefits.map((benefit, index) => (
                        <motion.div
                            key={index}
                            className="group bg-white p-8 rounded-2xl border border-slate-200 hover:border-amber-200 hover:shadow-xl hover:shadow-amber-500/5 transition-all duration-500"
                            initial={{ opacity: 0, y: 30 }}
                            whileInView={{ opacity: 1, y: 0 }}
                            viewport={{ once: true }}
                            transition={{ duration: 0.5, delay: index * 0.1 }}
                        >
                            <div className="w-12 h-12 bg-slate-100 group-hover:bg-amber-100 rounded-xl flex items-center justify-center transition-colors duration-300">
                                <benefit.icon className="w-6 h-6 text-slate-600 group-hover:text-amber-600 transition-colors duration-300" />
                            </div>
                            <h3 className="mt-6 text-lg font-semibold text-slate-900">
                                {benefit.title}
                            </h3>
                            <p className="mt-3 text-slate-600 leading-relaxed">
                                {benefit.description}
                            </p>
                        </motion.div>
                    ))}
                </div>
            </div>
        </section>
    );
}
