<script setup>
import { ref } from 'vue';

const props = defineProps(['rooms', 'currentRoom'])
const emit = defineEmits(['roomChanged'])

const selected = ref('')

selected.value = props.currentRoom
</script>

<template>
    <div class="grid grid-cols-2">
        <div class="font-bold text-xl">
            {{ selected.name }} Chat
        </div>
        <div>
            <select v-model="selected" @change="emit('roomChanged', selected)" class="float-right">
                <option v-for="(room, index) in rooms" :key="index" :value="room">
                    {{ room.name }}
                </option>
            </select>
        </div>
    </div>
</template>
