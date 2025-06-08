<script setup lang="ts">
import { Link } from '@inertiajs/vue3';

const currentYear = new Date().getFullYear();
</script>

<template>
    <footer class="w-full bg-[#1b1b18] py-8 text-[#EDEDEC]">
        <div class="mx-auto flex max-w-[1200px] flex-col px-6 lg:max-w-6xl">
            <div class="flex flex-col justify-between space-y-8 md:flex-row md:space-y-0">
                <!-- Logo -->
                <div class="flex flex-col">
                    <h2 class="text-xl font-bold">Meraki Shop</h2>
                </div>

                <!-- Navigation Links -->
                <div class="flex flex-col space-y-4 md:flex-row md:space-y-0 md:space-x-12">
                    <Link href="#" class="text-sm hover:text-white">About Us</Link>
                    <Link href="#" class="text-sm hover:text-white">Contact</Link>
                </div>

                <!-- Social Links -->
                <div class="flex space-x-4">
                    <a href="#" class="inline-flex h-9 w-9 items-center justify-center rounded-full bg-[#EDEDEC20] hover:bg-[#EDEDEC30]">
                        <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path
                                d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"
                            />
                        </svg>
                    </a>
                    <a href="#" class="inline-flex h-9 w-9 items-center justify-center rounded-full bg-[#EDEDEC20] hover:bg-[#EDEDEC30]">
                        <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path
                                d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"
                            />
                        </svg>
                    </a>
                </div>
            </div>

            <!-- Copyright -->
            <div class="mt-8 border-t border-[#EDEDEC20] pt-6 text-center text-xs text-[#EDEDEC80] md:text-left">
                © {{ currentYear }} Meraki Shop. All rights reserved.
            </div>
        </div>
    </footer>
</template>
