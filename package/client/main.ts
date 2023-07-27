import '@/components/datepicker'
import '@/components/grid'
import '@/plugins/form'
import '@/style.scss'
import { createIcons, icons } from 'lucide'
import { flashMessages } from './app/flash-messages'

// run app script
flashMessages()

// create icons rendered by the server
createIcons({ icons })
