<script setup lang="ts">
import { Avatar, AvatarFallback, AvatarImage } from '@/components/ui/avatar';
import { ref } from 'vue';

interface Testimonial {
    id: number;
    name: string;
    avatar: string;
    rating: number;
    comment: string;
    date: string;
}

const testimonials = ref<Testimonial[]>([
    {
        id: 1,
        name: 'Sarah Johnson',
        avatar: 'https://images.unsplash.com/photo-1494790108377-be9c29b29330',
        rating: 5,
        comment:
            'The Vintage Superman Action Figure is absolutely incredible! The detail is amazing and it perfectly completes my DC collection. Shipping was fast and secure.',
        date: '2023-10-15',
    },
    {
        id: 2,
        name: 'Michael Chen',
        avatar: 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d',
        rating: 4,
        comment:
            "I've been looking for the Limited Edition Star Wars Figurine for years! The condition is excellent and the authentication certificate provided gives me peace of mind.",
        date: '2023-09-28',
    },
    {
        id: 3,
        name: 'Emily Rodriguez',
        avatar: 'https://images.unsplash.com/photo-1438761681033-6461ffad8d80',
        rating: 5,
        comment:
            "The Rare Marvel Collection Box was worth every penny. These are genuine collector's items and I appreciate that they limit purchases to ensure true fans can acquire these pieces.",
        date: '2023-11-05',
    },
]);
</script>

<template>
    <section class="mt-16 mb-16">
        <h2 class="mb-4 text-left text-3xl font-bold text-[#1b1b18] dark:text-white">Collector Testimonials</h2>
        <p class="mb-8 max-w-2xl text-left text-[#555] dark:text-gray-300">
            Hear from fellow collectors who have added our rare pieces to their treasured collections.
        </p>
        <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">
            <div
                v-for="testimonial in testimonials"
                :key="testimonial.id"
                class="rounded-lg border border-[#19140020] p-6 shadow-sm dark:border-[#3E3E3A]"
            >
                <div class="mb-4 flex items-center space-x-4">
                    <Avatar class="h-12 w-12 overflow-hidden">
                        <AvatarImage :src="testimonial.avatar" :alt="testimonial.name" class="aspect-square object-cover" />
                        <AvatarFallback>{{ testimonial.name.charAt(0) }}</AvatarFallback>
                    </Avatar>
                    <div>
                        <h3 class="text-lg font-medium text-[#1b1b18] dark:text-white">{{ testimonial.name }}</h3>
                        <div class="flex">
                            <svg
                                v-for="i in 5"
                                :key="i"
                                xmlns="http://www.w3.org/2000/svg"
                                :class="['h-4 w-4', i <= testimonial.rating ? 'text-yellow-500' : 'text-gray-300']"
                                viewBox="0 0 20 20"
                                fill="currentColor"
                            >
                                <path
                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"
                                />
                            </svg>
                        </div>
                    </div>
                </div>
                <p class="text-sm text-[#1b1b18] dark:text-gray-300">{{ testimonial.comment }}</p>
                <p class="mt-4 text-xs text-[#1b1b1899] dark:text-gray-400">{{ testimonial.date }}</p>
            </div>
        </div>
    </section>
</template>
