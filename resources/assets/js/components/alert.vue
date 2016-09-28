<template>
    <div class="Alert Alert--{{ type | capitalize }}" transition="fade" v-show="show">
        <slot></slot>
        <span class="Alert__close" v-show="important" @click="show = false">
            X
        </span>
    </div>
</template>
<style>
    .Alert {
        padding: 10px;
        position: fixed;
        bottom:0;
        width:100%;
        text-align: center;
    }
    .Alert-- {
        background: rgba(0,0,0,0.8);
    }
    .Alert--Info {
        background: rgba(61, 150, 221, 0.8);
    }
    .Alert--Success {
        background: rgba(54, 168, 21, 0.8);
    }
    .Alert--Danger, .Alert--Error {
        background: rgba(218, 2, 0, 0.8);

    }
    .Alert__close {
        position: absolute;
        top: 10px;
        right: 30px;
        cursor: pointer;
        color:red;
    }
    .fade-transition {
        transition: opacity .4s ease;
    }
    .fade-leave {
        opacity:0;
    }
</style>
<script>
    export default{
        props: {
            type: { 'default': '' },
            timeout: { 'default': '5000' },
            important: {
                type: Boolean,
                'default': false
            }
        },
        data() {
            return {
                show: true
            };
        },
        ready() {
            if (! this.important ) {
                setTimeout(() => this.show = false,this.timeout);
            }
        }
    }
</script>
