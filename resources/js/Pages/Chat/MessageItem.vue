<script setup>
const props = defineProps(['message'])
</script>

<template>
    <div>
        {{ message.user.name }}: {{ message.message }}
    </div>
</template>
