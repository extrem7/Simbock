import CreateBtn from '@/components/includes/forms/CreateBtn'
import Search from "@/components/includes/forms/Search"
import ActionsButtons from "@/components/includes/forms/ActionsButtons"
import DragBtn from '@/components/includes/forms/DragBtn'

export const index = {
    data() {
        return {
            isBusy: false,
        }
    },
    provide() {
        return {
            resource: this.resource,
        }
    },
    components: {
        CreateBtn,
        ActionsButtons
    }
}

export const destroy = {
    methods: {
        async destroy(id, provided = false) {
            try {
                const destroy = await this.$confirm("Are you sure?")
                if (destroy) {
                    try {
                        this.isBusy = true
                        const {status, data} = await this.axios.delete(this.route(`admin.${this.resource}.destroy`, id))
                        if (status === 200) {
                            this.$bus.emit('alert', {text: data.status})
                            if (!provided)
                                this.items = this.items.filter(item => item.id !== id)
                            return true
                        }
                    } catch (e) {
                        console.log(e)
                    } finally {
                        this.isBusy = false
                    }
                }
            } catch (e) {
            }
        }
    }
}

export const sortable = {
    methods: {
        async sort() {
            const order = this.items.map(({id}) => id)
            this.isBusy = true
            try {
                const {status, data} = await this.axios.post(this.route(`admin.${this.resource}.sort`), {order})
                if (status === 200 && data.status) {
                    this.$bus.emit('alert', {text: data.status})
                }
            } catch (e) {
                console.log(e)
            } finally {
                this.isBusy = false
            }
        }
    },
    components: {
        Draggable: () => import( 'vuedraggable'),
        DragBtn
    }
}

export const datatable = {
    data() {
        return {
            initialized: false,
            isBusy: false,
            initial: null,
            searchQuery: '',

            perPage: null,
            currentPage: 1,

            sortBy: 'id',
            sortDesc: false,

            total: null,
        }
    },
    methods: {
        async items(ctx) {
            if (!this.initialized) {
                this.initialized = true
                return this.initial
            }
            this.isBusy = true
            try {
                const {data} = await this.axios.get(this.route(`admin.${this.resource}.index`), {
                    params: {
                        searchQuery: this.searchQuery,
                        page: ctx.currentPage,
                        sortBy: ctx.sortBy,
                        sortDesc: +ctx.sortDesc
                    },
                })
                this.isBusy = false

                this.perPage = data.per_page
                this.total = data.total

                return data.data
            } catch (error) {
                this.isBusy = false
                return []
            }
        },
        async destroy(resource, id) {
            if (await this.$super(destroy).destroy(resource, id, true))
                this.$refs.table.refresh()
        },
        search() {
            if (this.currentPage > 1) {
                this.resetPage()
            } else {
                this.$refs.table.refresh()
            }
        },
        resetPage() {
            this.currentPage = 1
        }
    },
    watch: {
        sortBy: 'resetPage',
        sortDesc: 'resetPage',
    },
    created() {
        this.initial = this.initialData.data
        this.perPage = this.initialData.per_page
        this.total = this.initialData.total
    },
    provide() {
        return {
            resource: this.resource,
        }
    },
    mixins: [index, destroy],
    components: {
        Search
    }
}

