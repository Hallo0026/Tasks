<template>
    <form>
        <div class="mb-3">
            <label for="group" class="form-label">Nome</label>
            <input type="text" class="form-control" id="group" name="group" v-model="group">
        </div>


        <div class="mb-3">
            <label for="group" class="form-label">Descrição (Opcional)</label>
            <input type="text" class="form-control" id="description" name="description" v-model="description">
        </div>

        <button type="button" class="btn btn-secondary float-start" id="close-modal-btn" ref="closeModalBtn" data-bs-dismiss="modal">
            Voltar
        </button>
        <button type="button" class="btn btn-primary float-end" @click="createGroup()">Adicionar</button>
    </form>
</template>

<script>
    import axios from 'axios';

    export default {
        data() {
            return {
                group: '',
                description: ''
            };
        },
        methods: {
            createGroup() {
                const url = '/api/v1/groups';

                const data = {
                    name: this.group,
                    description: this.description
                };

                axios.post(url, data)
                    .then(response => {
                        console.log(response.data);
                        this.$emit('group-created', response.data);
                        this.closeModal();
                    })
                    .catch(error => {
                        console.log(error);
                    });
            },
            closeModal() {
                this.$refs.closeModalBtn.click();
            }
        }
    }
</script>

