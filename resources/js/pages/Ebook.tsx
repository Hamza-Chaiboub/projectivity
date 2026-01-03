import React from 'react';
import HeroSection from '@/components/landing/HeroSection';
import EbookPreview from '@/components/landing/EbookPreview';
import BenefitsSection from '@/components/landing/BenefitsSection';
import SignupForm from '@/components/landing/SignupForm';
import Footer from '@/components/landing/Footer';

export default function Home() {
    return (
        <div className="min-h-screen bg-white">
            <HeroSection />
            <EbookPreview />
            <BenefitsSection />
            <SignupForm />
            <Footer />
        </div>
    );
}
