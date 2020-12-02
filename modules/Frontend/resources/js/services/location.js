import Vue from 'vue'

export default {
    async searchCity(query, loading = null) {
        if (loading) loading(true)
        try {
            const {data} = await Vue.axios.get(`/api/cities/${query}`)
            return data
        } catch (e) {
            console.log(e)
            return []
        } finally {
            if (loading) loading(false)
        }
    }
}
