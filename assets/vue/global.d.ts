interface Upvote {
  id?: number
  feedback: { id: number }
}

interface User {
  id: number
  email: string
  password: string
  fullName: string
  upvotes: Upvote[]
}

interface Window {
  user: User | null
}

interface UserComment {
  id: number
  body: string
  replies: UserComment[]
  ownedBy: {
    id: number
    username: string
    fullName: string
  }
}

interface Feedback {
  id: number
  title: string
  detail: string
  category: string
  status: string
  upvotes: number
  comments: UserComment[]
  commentCount: number
  ownedBy: {
    id: number
    username: string
    fullName: string
  }
}

interface FeedbackForm {
  title: string
  category: string
  status: string
  detail: string
}

interface Status {
  title: string
  description: string
  count: number
}

type SortOption = 'Most Upvotes' | 'Least Upvotes' | 'Most Comments' | 'Least Comments'

type CategoryOption = 'All' | 'UI' | 'UX' | 'Enhancement' | 'Bug' | 'Feature'

type SeverityOption = 'success' | 'info' | 'warn' | 'error' | 'secondary' | 'contrast'
