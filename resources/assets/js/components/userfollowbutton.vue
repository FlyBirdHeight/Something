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
        props:['user'],
        mounted() {
            //console.log(this.user);
            axios.get('/api/user/followers/'+this.user).then(response => {
                //console.log(response.data);
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
                return this.followed ? '已关注' : '关注他'
            }
        },
        methods: {
            follow() {
                 axios.post('/api/user/follow/user',{'user':this.user}).then(response => {
                     this.followed = response.data.followed;
                })
            }
        }
    }
</script>
