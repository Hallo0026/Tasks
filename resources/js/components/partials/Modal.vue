<template>
    <!-- Modal -->
    <div class="modal fade" id="addTaskModal" tabindex="-1" aria-labelledby="addTaskModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="addTaskModalLabel">
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
};
</script>

<style scoped>

    .modal-title {
        font-weight: 600;
    }

</style>
