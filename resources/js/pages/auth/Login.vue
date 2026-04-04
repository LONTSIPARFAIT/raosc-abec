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
    >
        <Head title="Connexion" />

        <div v-if="status" class="mb-4 rounded-xl bg-emerald-50 border border-emerald-200 p-3 text-center text-sm font-medium text-emerald-700">
            {{ status }}
        </div>

        <Form
            v-bind="store.form()"
            :reset-on-success="['password']"
            v-slot="{ errors, processing }"
            class="flex flex-col gap-6"
        >
            <div class="grid gap-5">
                <!-- Email -->
                <div class="grid gap-1">
                    <Label for="email">Adresse email</Label>
                    <Input
                        id="email"
                        type="email"
                        name="email"
                        required
                        autofocus
                        :tabindex="1"
                        autocomplete="email"
                        placeholder="exemple@raosc.org"
                    />
                    <InputError :message="errors.email" />
                </div>

                <!-- Password -->
                <div class="grid gap-1">
                    <div class="flex items-center justify-between">
                        <Label for="password">Mot de passe</Label>
                        <TextLink
                            v-if="canResetPassword"
                            :href="request()"
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
                    />
                    <InputError :message="errors.password" />
                </div>

                <!-- Remember Me -->
                <div class="flex items-center">
                    <Label class="flex items-center gap-2 cursor-pointer">
                        <Checkbox id="remember" name="remember" :tabindex="3" />
                        <span class="text-sm text-zinc-600">Se souvenir de moi</span>
                    </Label>
                </div>

                <!-- Submit -->
                <Button
                    type="submit"
                    :tabindex="4"
                    :disabled="processing"
                    class="w-full"
                >
                    <Spinner v-if="processing" class="mr-2" />
                    {{ processing ? 'Connexion en cours...' : 'Se connecter' }}
                </Button>
            </div>

            <!-- Register -->
            <div v-if="canRegister" class="text-center text-sm text-zinc-500">
                Vous n'avez pas encore de compte ?
                <TextLink :href="register()" :tabindex="5" class="ml-1">
                    Créer un compte
                </TextLink>
            </div>
        </Form>
    </AuthBase>
</template>