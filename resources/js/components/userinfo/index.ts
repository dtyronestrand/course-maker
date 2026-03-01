import type { VariantProps } from "class-variance-authority"
import { cva } from "class-variance-authority"


export { default as UserInfo } from "./UserInfo.vue"

export const avatarVariants = cva(
  "",
  {
    variants: {
      avatar: {
        "default": "h-8 w-8 overflow-hidden rounded-lg",
        "sm": "h-6 w-6 overflow-hidden rounded-md",
        "lg": "h-10 w-10 overflow-hidden rounded-md",
      },
    },
    defaultVariants: {
      avatar: "default",
    },
  },
)

export const fallbackVariants = cva(
  "rounded-lg text-black dark:text-white",
  {
    variants: {
      fallback: {
        "default": "",
        "sm": "h-6 w-6 rounded-md text-xs",
        "lg": "h-10 w-10 rounded-md text-lg",
      },
    },
    defaultVariants: {
      fallback: "default",
    },
  },
)

export const roleVariants = cva(
  "text-lg text-center text-white",
  {
    variants: {
      role: {
        "default": "",
        "uppercase": "uppercase",
        "hidden": "hidden ",
        
      },
    },
    defaultVariants: {
      role: "default",
    },
  },
)

export type AvatarVariants = VariantProps<typeof avatarVariants>
export type FallbackVariants = VariantProps<typeof fallbackVariants>
export type RoleVariants = VariantProps<typeof roleVariants>
