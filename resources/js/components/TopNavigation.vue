<script setup lang="ts">
import AppLogo from '@/components/AppLogo.vue';
import { Avatar, AvatarFallback, AvatarImage } from '@/components/ui/avatar';
import { Button } from '@/components/ui/button';
import { DropdownMenu, DropdownMenuContent, DropdownMenuTrigger } from '@/components/ui/dropdown-menu';
import UserMenuContent from '@/components/UserMenuContent.vue';
import { getInitials } from '@/composables/useInitials';
import type { BreadcrumbItem } from '@/types';
import { Link, usePage } from '@inertiajs/vue3';
import { BarChart3, Heart, Inbox, LayoutDashboard, Send, User } from 'lucide-vue-next';
import { computed } from 'vue';

interface Props {
    breadcrumbs?: BreadcrumbItem[];
}

const props = withDefaults(defineProps<Props>(), {
    breadcrumbs: () => [],
});

const page = usePage();
const auth = computed(() => page.props.auth);

const isCurrentRoute = computed(() => (url: string) => page.url === url);

const navigationItems = [
    {
        title: 'Dashboard',
        href: '/dashboard',
        icon: LayoutDashboard,
    },
    {
        title: 'Sent',
        href: '/outgoing',
        icon: Send,
    },
    {
        title: 'Received',
        href: '/received',
        icon: Inbox,
    },
    {
        title: 'Offers',
        href: '/offers',
        icon: Heart,
    },
    {
        title: 'Analytics',
        href: '/analytics',
        icon: BarChart3,
    },
];
</script>

<template>
    <div class="border-b bg-white dark:bg-gray-900 dark:border-gray-700">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex h-16 items-center justify-between">
                <!-- Logo -->
                <div class="flex items-center">
                    <Link :href="route('dashboard')" class="flex items-center">
                        <AppLogo />
                    </Link>
                </div>

                <!-- Navigation Items -->
                <nav class="hidden md:flex md:space-x-8">
                    <Link
                        v-for="item in navigationItems"
                        :key="item.title"
                        :href="item.href"
                        :class="[
                            'inline-flex items-center px-3 py-2 text-sm font-medium rounded-md transition-colors duration-200',
                            isCurrentRoute(item.href)
                                ? 'bg-blue-100 text-blue-700 dark:bg-blue-900 dark:text-blue-300'
                                : 'text-gray-700 hover:text-blue-600 hover:bg-gray-100 dark:text-gray-300 dark:hover:text-blue-400 dark:hover:bg-gray-800'
                        ]"
                    >
                        <component :is="item.icon" class="mr-2 h-4 w-4" />
                        {{ item.title }}
                    </Link>
                </nav>

                <!-- User Menu -->
                <div class="flex items-center space-x-4">
                    <!-- Mobile menu button (for future mobile support) -->
                    <div class="md:hidden">
                        <Button variant="ghost" size="icon">
                            <User class="h-5 w-5" />
                        </Button>
                    </div>

                    <!-- User dropdown -->
                    <DropdownMenu>
                        <DropdownMenuTrigger :as-child="true">
                            <Button
                                variant="ghost"
                                size="icon"
                                class="relative size-10 w-auto rounded-full p-1 focus-within:ring-2 focus-within:ring-primary"
                            >
                                <Avatar class="size-8 overflow-hidden rounded-full">
                                    <AvatarImage v-if="auth.user.avatar" :src="auth.user.avatar" :alt="auth.user.name" />
                                    <AvatarFallback class="rounded-lg bg-neutral-200 font-semibold text-black dark:bg-neutral-700 dark:text-white">
                                        {{ getInitials(auth.user?.name) }}
                                    </AvatarFallback>
                                </Avatar>
                            </Button>
                        </DropdownMenuTrigger>
                        <DropdownMenuContent align="end" class="w-56">
                            <UserMenuContent :user="auth.user" />
                        </DropdownMenuContent>
                    </DropdownMenu>
                </div>
            </div>
        </div>

        <!-- Mobile Navigation Menu (hidden by default, can be expanded later) -->
        <div class="md:hidden">
            <div class="px-2 pt-2 pb-3 space-y-1 border-t dark:border-gray-700">
                <Link
                    v-for="item in navigationItems"
                    :key="item.title"
                    :href="item.href"
                    :class="[
                        'flex items-center px-3 py-2 text-base font-medium rounded-md transition-colors duration-200',
                        isCurrentRoute(item.href)
                            ? 'bg-blue-100 text-blue-700 dark:bg-blue-900 dark:text-blue-300'
                            : 'text-gray-700 hover:text-blue-600 hover:bg-gray-100 dark:text-gray-300 dark:hover:text-blue-400 dark:hover:bg-gray-800'
                    ]"
                >
                    <component :is="item.icon" class="mr-3 h-5 w-5" />
                    {{ item.title }}
                </Link>
            </div>
        </div>
    </div>
</template> 