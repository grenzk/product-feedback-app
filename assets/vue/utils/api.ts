class FetchWrapper {
  async request(
    method: string,
    url: string,
    data: Record<string, any> | null,
    headers: HeadersInit = {}
  ) {
    const config: RequestInit = {
      method,
      headers: {
        'Content-Type': 'application/ld+json',
        ...headers
      }
    }

    if (data) {
      config.body = JSON.stringify(data)
    }

    const response = await fetch(url, config)

    if (!response.ok) {
      const errorData = await response.json()
      throw new Error(errorData.error)
    }

    return response
  }

  get(url: string, headers: HeadersInit = {}) {
    return this.request('GET', url, null, headers)
  }

  post(url: string, data: Record<string, any> | null, headers: HeadersInit = {}) {
    return this.request('POST', url, data, headers)
  }

  put(url: string, data: Record<string, any> | null, headers: HeadersInit = {}) {
    return this.request('PUT', url, data, headers)
  }

  delete(url: string, headers: HeadersInit = {}) {
    return this.request('DELETE', url, null, headers)
  }
}

export const http = new FetchWrapper()
