export default {
    store(payload) {
        return new Promise((resolve, reject) => {
            axios.post('/api/log', payload).then(response => {
                resolve()
            }).catch(error => reject(error))
        })
    }
}