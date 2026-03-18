<script setup lang="ts">
import { Head, useForm } from '@inertiajs/vue3';
import InputError from '@/components/InputError.vue';
import TextLink from '@/components/TextLink.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Spinner } from '@/components/ui/spinner';
import AuthBase from '@/layouts/AuthLayout.vue';
import { login } from '@/routes';
import { store } from '@/routes/register';
import { ref, computed } from 'vue';

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
});

// Client-side validation errors
const clientErrors = ref<{
    name?: string;
    email?: string;
    password?: string;
    password_confirmation?: string;
}>({});

const validate = () => {
    clientErrors.value = {}; // Clear previous errors
    let isValid = true;

    // Name validation
    if (!form.name) {
        clientErrors.value.name = 'The name field is required.';
        isValid = false;
    } else if (form.name.length > 255) {
        clientErrors.value.name =
            'The name must not be greater than 255 characters.';
        isValid = false;
    }

    // Email validation
    if (!form.email) {
        clientErrors.value.email = 'The email field is required.';
        isValid = false;
    } else if (!/\S+@\S+\.\S+/.test(form.email)) {
        clientErrors.value.email = 'The email must be a valid email address.';
        isValid = false;
    } else if (form.email.length > 255) {
        clientErrors.value.email =
            'The email must not be greater than 255 characters.';
        isValid = false;
    }
    // Note: 'unique' email check is server-side only.

    // Password validation
    if (!form.password) {
        clientErrors.value.password = 'The password field is required.';
        isValid = false;
    } else if (form.password.length < 8) {
        // Minimum length based on Laravel's Password::default()
        clientErrors.value.password =
            'The password must be at least 8 characters.';
        isValid = false;
    }
    // Stronger password rules (mixed case, symbols, numbers) are harder to check client-side without a library.
    // For simplicity, we'll keep it to length for now, and rely on server for full complexity.

    // Password confirmation validation
    if (!form.password_confirmation) {
        clientErrors.value.password_confirmation =
            'The password confirmation field is required.';
        isValid = false;
    } else if (form.password !== form.password_confirmation) {
        clientErrors.value.password_confirmation =
            'The password confirmation does not match.';
        isValid = false;
    }

    return isValid;
};

const submit = () => {
    if (!validate()) {
        return; // Stop submission if client-side validation fails
    }

    form.post(route('register.store'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};

const hasErrors = computed(() => {
    return (
        Object.keys(clientErrors.value).length > 0 ||
        Object.keys(form.errors).length > 0
    );
});
</script>

<template>
    <AuthBase
        title="Create an account"
        description="Enter your details below to create your account"
    >
        <Head title="Register" />

        <form @submit.prevent="submit" class="flex flex-col gap-6">
            <div class="grid gap-6">
                <div class="grid gap-2">
                    <Label for="name">Name</Label>
                    <Input
                        id="name"
                        type="text"
                        v-model="form.name"
                        required
                        autofocus
                        :tabindex="1"
                        autocomplete="name"
                        placeholder="Full name"
                        @input="clientErrors.name = undefined"
                    />
                    <InputError
                        :message="clientErrors.name || form.errors.name"
                    />
                </div>

                <div class="grid gap-2">
                    <Label for="email">Email address</Label>
                    <Input
                        id="email"
                        type="email"
                        v-model="form.email"
                        required
                        :tabindex="2"
                        autocomplete="email"
                        placeholder="email@example.com"
                        @input="clientErrors.email = undefined"
                    />
                    <InputError
                        :message="clientErrors.email || form.errors.email"
                    />
                </div>

                <div class="grid gap-2">
                    <Label for="password">Password</Label>
                    <Input
                        id="password"
                        type="password"
                        v-model="form.password"
                        required
                        :tabindex="3"
                        autocomplete="new-password"
                        placeholder="Password"
                        @input="clientErrors.password = undefined"
                    />
                    <InputError
                        :message="clientErrors.password || form.errors.password"
                    />
                </div>

                <div class="grid gap-2">
                    <Label for="password_confirmation">Confirm password</Label>
                    <Input
                        id="password_confirmation"
                        type="password"
                        v-model="form.password_confirmation"
                        required
                        :tabindex="4"
                        autocomplete="new-password"
                        placeholder="Confirm password"
                        @input="clientErrors.password_confirmation = undefined"
                    />
                    <InputError
                        :message="
                            clientErrors.password_confirmation ||
                            form.errors.password_confirmation
                        "
                    />
                </div>

                <Button
                    type="submit"
                    class="mt-2 w-full"
                    tabindex="5"
                    :disabled="form.processing"
                    data-test="register-user-button"
                >
                    <Spinner v-if="form.processing" />
                    Create account
                </Button>
            </div>

            <div class="text-center text-sm text-muted-foreground">
                Already have an account?
                <TextLink
                    :href="login()"
                    class="underline underline-offset-4"
                    :tabindex="6"
                    >Log in</TextLink
                >
            </div>
        </form>
    </AuthBase>
</template>
