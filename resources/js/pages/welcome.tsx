import React from 'react';
import { AppShell } from '@/components/app-shell';
import { Button } from '@/components/ui/button';
import Heading from '@/components/heading';
import { router } from '@inertiajs/react';

interface Props {
    count: number;
    [key: string]: unknown;  // REQUIRED for Inertia.js TypeScript compatibility
}

export default function Welcome({ count }: Props) {
    const handleIncrement = () => {
        router.post(route('counter.store'), {}, {
            preserveState: true,
            preserveScroll: true
        });
    };

    return (
        <AppShell>
            <div className="flex min-h-screen items-center justify-center bg-gray-50 dark:bg-gray-900">
                <div className="w-full max-w-md rounded-lg bg-white p-8 shadow-lg dark:bg-gray-800">
                    <div className="text-center">
                        <Heading title="Counter App" />
                        <div className="mt-8">
                            <div className="text-6xl font-bold text-blue-600 dark:text-blue-400">
                                {count}
                            </div>
                            <p className="mt-2 text-gray-600 dark:text-gray-400">Current Count</p>
                        </div>
                        <div className="mt-8">
                            <Button 
                                onClick={handleIncrement}
                                size="lg"
                                className="w-full"
                            >
                                Increment Counter
                            </Button>
                        </div>
                    </div>
                </div>
            </div>
        </AppShell>
    );
}