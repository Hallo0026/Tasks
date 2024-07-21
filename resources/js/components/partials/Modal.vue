<template>
    <!-- Modal -->
    <div class="modal fade" :id="modalId" tabindex="-1" aria-labelledby="ModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="ModalLabel">
                        <slot name="title"></slot>
                    </h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <slot name="body">...</slot>
                </div>
                <!--<div class="modal-footer">
                    <slot name="footer">

                    </slot>
                </div>-->
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'ModalComponent',
    props: ['modalId'],
};
</script>

<style scoped>

    .modal-title {
        font-weight: 600;
    }

</style>
