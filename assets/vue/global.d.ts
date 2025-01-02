declare interface User {
  email: string
  password: string
}

declare interface Window {
  user: User | null
}

declare interface Feedback {
  id: number
  title: string
  detail: string
  category: string
  status: string
  upvotes: number
}
