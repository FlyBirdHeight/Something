<template>
    <button
            class="btn btn-default pull-left"
            v-text="text"
            v-on:click="follow"
            v-bind:class="{'btn-success': followed}"
    ></button>
</template>

<script>
    export default{
        props:['question','user'],
        mounted() {
            axios.post('/api/question/follower',{'question':this.question,'user':this.user}).then(response => {
                this.followed = response.data.followed;
            })
        },
        data() {
            return {
                followed: false
            }
        },
        computed: {
            text() {
                return this.followed ? '已关注该问题' : '关注该问题'
            }
        },
        methods: {
            follow() {
                 axios.post('/api/question/follow',{'question':this.question,'user':this.user}).then(response => {
                    this.followed = response.data.followed;
                })
            }
        }
    }
</script>
