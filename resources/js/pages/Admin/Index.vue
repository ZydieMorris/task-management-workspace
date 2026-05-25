<template>
    <div class="p-10">
          <GreetingsUser :user="user"/>
    </div>
</template>

<script setup lang="ts">
import GreetingsUser from '@/components/admin/dashboard/GreetingsUser.vue';
import { User } from '@/types';
import { usePage } from '@inertiajs/vue3';

const page =usePage();
const user = page.props.auth.user as User;


</script>


