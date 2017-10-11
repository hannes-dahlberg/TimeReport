import log from '../../../api/log'

export default {
    actions: {
        addLog({}, payload) {
            return new Promise((resolve, reject) => {
                log.store(payload).then(() => resolve()).catch(error => reject(error));
            })
        }
    }
}