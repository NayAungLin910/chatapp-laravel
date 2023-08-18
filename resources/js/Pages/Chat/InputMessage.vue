<script setup>
import axios from 'axios';
import { ref } from 'vue';

const props = defineProps(['room'])
const emit = defineEmits(['messageSent', 'look'])

const message = ref('')

function sendMessage() {
    if (message.value === '') {
        return
    }

    axios.post(`/chat/room/${props.room.id}/message`, {
        message: message.value
    })
        .then((response) => {
            message.value = ''
            emit('messageSent')
            emit('look')
        })
        .catch((error) => {
            console.log(error)
        })
}
</script>

<template>
    <div class="relative h-10 m-1">
        <div style="border-top: 1px solid #e6e6e6;" class="grid grid-cols-6">
            <input type="text" v-model="message" @keyup.enter="sendMessage" placeholder="Something..."
                class="col-span-5 outline-none p-1" />
            <button @click="sendMessage" class="place-self-end bg-gray-500 hover:bg-blue-700 p-1 mt-1 rounded text-white">
                Send
            </button>
        </div>
    </div>
</template>
