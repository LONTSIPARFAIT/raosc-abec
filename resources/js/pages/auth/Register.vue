<script setup lang="ts">
import { Form, Head } from '@inertiajs/vue3';
import InputError from '@/components/InputError.vue';
import PasswordInput from '@/components/PasswordInput.vue';
import TextLink from '@/components/TextLink.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Spinner } from '@/components/ui/spinner';
import AuthBase from '@/layouts/AuthLayout.vue';
import { login } from '@/routes';
import { store } from '@/routes/register';

defineProps<{
    canResetPassword?: boolean;
}>();
</script>

<template>
    <AuthBase
        title="Créer un compte"
    >
        <Head title="Inscription" />

        <Form
            v-bind="store.form()"
            :reset-on-success="['password', 'password_confirmation']"
            v-slot="{ errors, processing }"
            class="flex flex-col gap-6"
        >
            <div class="grid gap-5">
                <!-- Nom complet -->
                <div class="grid gap-1">
                    <Label for="name">Nom complet</Label>
                    <Input
                        id="name"
                        type="text"
                        required
                        autofocus
                        :tabindex="1"
                        autocomplete="name"
                        name="name"
                        placeholder="Jean Dupont"
                    />
                    <InputError :message="errors.name" />
                </div>

                <!-- Email -->
                <div class="grid gap-1">
                    <Label for="email">Adresse email</Label>
                    <Input
                        id="email"
                        type="email"
                        required
                        :tabindex="2"
                        autocomplete="email"
                        name="email"
                        placeholder="jean@exemple.org"
                    />
                    <InputError :message="errors.email" />
                </div>

                <!-- Mot de passe -->
                <div class="grid gap-1">
                    <Label for="password">Mot de passe</Label>
                    <PasswordInput
                        id="password"
                        required
                        :tabindex="3"
                        autocomplete="new-password"
                        name="password"
                        placeholder="Créez un mot de passe sécurisé"
                    />
                    <InputError :message="errors.password" />
                </div>

                <!-- Confirmation mot de passe -->
                <div class="grid gap-1">
                    <Label for="password_confirmation">Confirmer le mot de passe</Label>
                    <PasswordInput
                        id="password_confirmation"
                        required
                        :tabindex="4"
                        autocomplete="new-password"
                        name="password_confirmation"
                        placeholder="Confirmez votre mot de passe"
                    />
                    <InputError :message="errors.password_confirmation" />
                </div>

                <!-- Bouton d'inscription -->
                <Button
                    type="submit"
                    :tabindex="5"
                    :disabled="processing"
                    class="w-full mt-2"
                >
                    <Spinner v-if="processing" class="mr-2" />
                    {{ processing ? 'Inscription en cours...' : 'Créer mon compte' }}
                </Button>
            </div>

            <!-- Lien de connexion -->
            <div class="text-center text-sm text-zinc-500">
                Vous avez déjà un compte ?
                <TextLink
                    :href="login()"
                    :tabindex="6"
                    class="ml-1"
                >
                    Se connecter
                </TextLink>
            </div>
        </Form>
    </AuthBase>
</template>