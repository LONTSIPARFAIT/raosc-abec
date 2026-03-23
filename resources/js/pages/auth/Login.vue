<script setup lang="ts">
import { Form, Head } from '@inertiajs/vue3';
import InputError from '@/components/InputError.vue';
import PasswordInput from '@/components/PasswordInput.vue';
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

defineProps<{
    status?: string;
    canResetPassword: boolean;
    canRegister: boolean;
}>();
</script>

<template>
    <AuthBase
        title="Connexion à votre compte"
        description="Entrez votre email et votre mot de passe pour vous connecter"
    >
        <Head title="Connexion" />

        <div
            v-if="status"
            class="mb-4 text-center text-sm font-medium text-emerald-600 dark:text-emerald-400"
        >
            {{ status }}
        </div>

        <Form
            v-bind="store.form()"
            :reset-on-success="['password']"
            v-slot="{ errors, processing }"
            class="flex flex-col gap-6"
        >
            <div class="grid gap-5">
                <div class="grid gap-2">
                    <Label for="email" class="text-sm font-medium">Adresse email</Label>
                    <Input
                        id="email"
                        type="email"
                        name="email"
                        required
                        autofocus
                        :tabindex="1"
                        autocomplete="email"
                        placeholder="exemple@raosc.org"
                        class="rounded-xl border-zinc-200 dark:border-zinc-700 bg-zinc-50 dark:bg-zinc-800 focus:ring-2 focus:ring-raosc-green/20 focus:border-raosc-green"
                    />
                    <InputError :message="errors.email" />
                </div>

                <div class="grid gap-2">
                    <div class="flex items-center justify-between">
                        <Label for="password" class="text-sm font-medium">Mot de passe</Label>
                        <TextLink
                            v-if="canResetPassword"
                            :href="request()"
                            class="text-sm text-raosc-green hover:text-raosc-green/80"
                            :tabindex="5"
                        >
                            Mot de passe oublié ?
                        </TextLink>
                    </div>
                    <PasswordInput
                        id="password"
                        name="password"
                        required
                        :tabindex="2"
                        autocomplete="current-password"
                        placeholder="Votre mot de passe"
                        class="rounded-xl border-zinc-200 dark:border-zinc-700 bg-zinc-50 dark:bg-zinc-800 focus:ring-2 focus:ring-raosc-green/20 focus:border-raosc-green"
                    />
                    <InputError :message="errors.password" />
                </div>

                <div class="flex items-center justify-between">
                    <Label for="remember" class="flex items-center space-x-3 text-sm">
                        <Checkbox id="remember" name="remember" :tabindex="3" />
                        <span>Se souvenir de moi</span>
                    </Label>
                </div>

                <Button
                    type="submit"
                    class="mt-2 w-full bg-raosc-green hover:bg-raosc-green/90 text-white font-semibold rounded-full py-2.5 shadow-sm transition-all"
                    :tabindex="4"
                    :disabled="processing"
                    data-test="login-button"
                >
                    <Spinner v-if="processing" />
                    Se connecter
                </Button>
            </div>

            <div
                class="text-center text-sm text-zinc-500 dark:text-zinc-400"
                v-if="canRegister"
            >
                Vous n'avez pas encore de compte ?
                <TextLink :href="register()" :tabindex="5" class="text-raosc-green font-semibold hover:text-raosc-green/80">
                    Créer un compte
                </TextLink>
            </div>
        </Form>
    </AuthBase>
</template>