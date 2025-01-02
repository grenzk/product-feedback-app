declare interface User {
  email: string
  password: string
}

declare interface Window {
  user: User | null
}

declare interface UserComment {
  id: number
  body: string
  replies: UserComment[]
  ownedBy: {
    username: string
    fullName: string
  }
}

declare interface Feedback {
  id: number
  title: string
  detail: string
  category: string
  status: string
  upvotes: number
  comments: UserComment[]
  commentCount: number
}
