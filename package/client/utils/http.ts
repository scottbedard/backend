import { merge } from 'lodash-es'
import axios from 'axios'

export const http = {

  /**
   * Get request to backend
   */
  async get<T = any>(url: string, opts: Parameters<typeof axios['get']>[1] = {}) {
    return axios.get<T>(url, merge({
      headers: {
        'X-Backend': true,
      },
    }, opts))
  }

}
