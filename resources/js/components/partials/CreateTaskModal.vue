<template>
    <form>
        <div class="mb-3">
            <label for="task" class="form-label">Tarefa</label>
            <input type="text" class="form-control" id="task" name="task" v-model="task">
        </div>

        <div class="row">
            <div class="col-6 mb-3">
                <label for="due_date" class="form-label">Data de conclusão</label>
                <input type="date" class="form-control" id="due_date" name="due_date" v-model="dueDate">
            </div>

            <div class="col-6 mb-3">
                <label for="due_date" class="form-label">&nbsp;</label>
                <input type="time" class="form-control" id="due_time" name="due_time" v-model="dueTime">
            </div>
        </div>

        <div class="mb-3">
            <label for="task" class="form-label">Descrição (Opcional)</label>
            <input type="text" class="form-control" id="task" name="task" v-model="description">
        </div>

        <button type="button" class="btn btn-secondary float-start" id="close-modal-btn" ref="closeModalBtn" data-bs-dismiss="modal">
            Voltar
        </button>
        <button type="button" class="btn btn-primary float-end" @click="createTask()">Adicionar</button>
    </form>
</template>

<script>
    import axios from 'axios';

    export default {
        data() {
            return {
                task: '',
                dueDate: '',
                dueTime: '',
                description: ''
            };
        },
        methods: {
            createTask() {
                const url = '/api/v1/tasks';

                this.dueDate = this.dueDate + ' ' + this.dueTime;

                const data = {
                    task: this.task,
                    due_date: this.dueDate,
                    description: this.description
                };

                axios.post(url, data)
                    .then(response => {
                        console.log(response.data);
                        this.$emit('task-created', response.data);
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

