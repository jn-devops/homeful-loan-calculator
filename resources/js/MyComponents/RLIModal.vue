<script setup>
defineProps({
    show: Boolean
})
</script>
<template>
    <!-- <Transition
    enter-from-class="opacity-0 scale-125"
    enter-to-class="opacity-100 scale-100"
    leave-from-class="opacity-100 scale-100"
    leave-to-class="opacity-0 scale-125"
    enter-active-class="transition duration-300"
    leave-active-class="transition duration-200"
    > -->
    <Transition name="modal">
        <div v-if="show" 
        class="modal-mask"
        @click.self="$emit('closeModal')"
        >
            <div class="modal-container w-full max-w-2xl">
                 <div>
                    <slot> default body</slot>
                 </div>
    
                <footer v-if="$slots.footer" class="modal-footer">
                    <slot name="footer">
                        <button @click="$emit('closeModal')">Close</button>
                    </slot>
                </footer>
            </div>
        </div>
    </Transition>
</template>

<style>
.modal-mask{
    position: fixed;
    inset: 0;
    background: rgba(0,0,0, 0.6);
    display: grid;
    place-items: center;
}
.modal-container{
    background-color: white;
    padding: 1rem;
    /* width: 680vw; */
    /* max-width: 500px; */
    border-radius: 7px;
}
.modal-footer{
    border-top: 1px solid #ddd;
    margin-top: 1rem;
    padding-top: 0.5rem;
    font-size: .8rem;
}
.modal-footer button{
    background: #ddd;
    padding: .25rem .75rem;
    border-radius: 20px;
}
.modal-footer button:hover{
    background: #c8c8c8;
}

.modal-enter-active, .modal-leave-active{
    /* @apply duration-300; */
    transition: opacity .3s;
}
.modal-enter-from, .modal-leave-to{
    opacity: 0;
}
.modal-enter-to, .modal-leave-from{
    opacity: 100;
}
</style>