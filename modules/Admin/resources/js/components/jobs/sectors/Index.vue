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
                    <th>Roles</th>
                    <th class="actions-column"></th>
                </tr>
                </thead>
                <draggable @update="sort" handle=".drag" tag="tbody" v-model="items">
                    <tr :key="id" v-for="{id,name,roles_count} in items">
                        <drag-btn/>
                        <td>{{ id }}</td>
                        <td>{{ name }}</td>
                        <td><a :href="route('admin.sectors.roles',id)">{{ roles_count }}</a></td>
                        <td>
                            <actions-buttons :id="id" @delete="destroy(id)"></actions-buttons>
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
                items: this.shared('sectors'),
                resource: 'sectors'
            }
        }
    }
</script>
