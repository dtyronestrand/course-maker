<script setup lang="ts">
import { Head, useForm } from '@inertiajs/vue3';
import InputError from '@/components/InputError.vue';
import TextLink from '@/components/TextLink.vue';
import { Button } from '@/components/ui/button';
import { Checkbox } from '@/components/ui/checkbox';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Spinner } from '@/components/ui/spinner';
import AuthBase from '@/layouts/AuthLayout.vue';
import { register } from '@/routes';
import { store } from '@/routes/login';
import { request } from '@/routes/password';
import { computed, ref } from 'vue';

defineProps<{
    status?: string;
    canResetPassword: boolean;
    canRegister: boolean;
}>();

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

// Client-side validation errors
const clientErrors = ref<{ email?: string; password?: string }>({});

const validate = () => {
    clientErrors.value = {}; // Clear previous errors
    let isValid = true;

    if (!form.email) {
        clientErrors.value.email = 'The email field is required.';
        isValid = false;
    } else if (!/\S+@\S+\.\S+/.test(form.email)) {
        clientErrors.value.email = 'The email must be a valid email address.';
        isValid = false;
    }

    if (!form.password) {
        clientErrors.value.password = 'The password field is required.';
        isValid = false;
    } else if (form.password.length < 8) {
        // Assuming a minimum password length of 8 as a common practice
        clientErrors.value.password = 'The password must be at least 8 characters.';
        isValid = false;
    }

    return isValid;
};

const submit = () => {
    if (!validate()) {
        return; // Stop submission if client-side validation fails
    }

    form.post(route('login.store'), {
        onFinish: () => form.reset('password'),
    });
};

const hasErrors = computed(() => {
    return Object.keys(clientErrors.value).length > 0 || Object.keys(form.errors).length > 0;
});
</script>

<template>
    <AuthBase
        title="Log in to your account"
        description="Enter your email and password below to log in"
    >
        <Head title="Log in" />

        <div
            v-if="status"
            class="mb-4 text-center text-sm font-medium text-green-600"
        >
            {{ status }}
        </div>

        <form @submit.prevent="submit" class="flex flex-col gap-6">
            <div class="grid gap-6">
                <div class="grid gap-2 text-amber-400">
                    <Label for="email">Email address</Label>
                    <Input
                        class="text-slate-700"
                        id="email"
                        type="email"
                        v-model="form.email"
                        required
                        autofocus
                        :tabindex="1"
                        autocomplete="email"
                        placeholder="email@example.com"
                        @input="clientErrors.email = undefined"
                    />
                    <InputError :message="clientErrors.email || form.errors.email" />
                </div>

                <div class="grid gap-2">
                    <div
                        class="flex items-center justify-between text-amber-400"
                    >
                        <Label for="password">Password</Label>
                        <TextLink
                            v-if="canResetPassword"
                            :href="request()"
                            class="text-sm"
                            :tabindex="5"
                        >
                            Forgot password?
                        </TextLink>
                    </div>
                    <Input
                        class="text-slate-700"
                        id="password"
                        type="password"
                        v-model="form.password"
                        required
                        :tabindex="2"
                        autocomplete="current-password"
                        placeholder="Password"
                        @input="clientErrors.password = undefined"
                    />
                    <InputError :message="clientErrors.password || form.errors.password" />
                </div>

                <div class="flex items-center justify-between text-amber-400">
                    <Label for="remember" class="flex items-center space-x-3">
                        <Checkbox id="remember" name="remember" v-model:checked="form.remember" :tabindex="3" />
                        <span>Remember me</span>
                    </Label>
                </div>

                <Button
                    type="submit"
                    class="mt-4 w-full bg-amber-500"
                    :tabindex="4"
                    :disabled="form.processing"
                    data-test="login-button"
                >
                    <Spinner v-if="form.processing" />
                    Log in
                </Button>
            </div>

            <div class="text-center text-sm text-amber-400" v-if="canRegister">
                Don't have an account?
                <TextLink :href="register()" :tabindex="5">Sign up</TextLink>
            </div>
        </form>

    </AuthBase>
</template>
