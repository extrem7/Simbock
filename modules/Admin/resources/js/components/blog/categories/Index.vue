<template>
    <div class="col-12">
        <create-btn></create-btn>
        <b-overlay :opacity="0.5" :show="isBusy">
            <table class="table table-striped table-hover table-striped table-bordered">
                <thead>
                <tr>
                    <th></th>
                    <th class="id-column">ID</th>
                    <th>Name</th>
                    <th class="actions-column"></th>
                </tr>
                </thead>
                <draggable @update="sort" handle=".drag" tag="tbody" v-model="items">
                    <tr :key="item.id" v-for="item in items">
                        <drag-btn/>
                        <td>{{ item.id }}</td>
                        <td>{{item.name}}</td>
                        <td>
                            <actions-buttons :id="item.id" @delete="destroy(item.id)"></actions-buttons>
                        </td>
                    </tr>
                </draggable>
            </table>
        </b-overlay>
    </div>
</template>

<script>
    import {index, destroy, sortable} from '@/mixins/index-table'

    export default {
        mixins: [index, destroy, sortable],
        data() {
            return {
                items: this.shared('categories'),
                resource: 'blog.categories'
            }
        }
    }
</script>
