<template>
    <div class="border w-full h-auto p-8" >
        Welcome back! {{ user.name }}
    </div>
</template>

<script setup lang="ts">
import { User } from '@/types';

        defineProps<{
            user: User,
        }>();
</script>


