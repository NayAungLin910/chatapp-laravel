<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import MessageContainer from './MessageContainer.vue';
import InputMessage from './InputMessage.vue';
import ChatRoomSelection from './ChatRoomSelection.vue';

import axios from 'axios';
import { ref } from 'vue';

const chatRooms = ref([]);
const currentRoom = ref({});
const messages = ref([]);

const getRooms = () => {
    axios.get('/chat/rooms')
        .then((response) => {
            chatRooms.value = response.data;
            setRoom(response.data[0])
        })
        .catch((error) => {
            console.log(error)
        })
}

const setRoom = (room) => {
    currentRoom.value = room
    getMessages()
}

const getMessages = () => {
    axios.get(`/chat/room/${currentRoom.value.id}/messages`)
        .then((response) => {
            messages.value = response.data
        })
        .catch((error) => {
            console.log(error)
        })
}

// no ned to call this function inside in created() since
// setup runs beforeCreate and created lifecycle
// https://stackoverflow.com/questions/64897835/what-is-an-equivalent-of-created-in-the-vue-js-composition-api
getRooms()

</script>

<template>
    <AppLayout title="Dashboard Header">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                <ChatRoomSelection v-if="currentRoom.id" :rooms="chatRooms" :currentRoom="currentRoom"
                    @room-changed="setRoom($event)" />
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <MessageContainer :messages="messages" />
                    <InputMessage @message-sent="getMessages" :room="currentRoom" />
                </div>
            </div>
        </div>
    </AppLayout>
</template>
