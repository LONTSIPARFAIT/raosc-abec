<script setup lang="ts">
import { Form, Head } from '@inertiajs/vue3';
import { ref } from 'vue';
import InputError from '@/components/InputError.vue';
import PasswordInput from '@/components/PasswordInput.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Spinner } from '@/components/ui/spinner';
import AuthLayout from '@/layouts/AuthLayout.vue';
import { update } from '@/routes/password';

const props = defineProps<{
    token: string;
    email: string;
}>();

const inputEmail = ref(props.email);
</script>

<template>
    <AuthLayout
        title="Réinitialisation du mot de passe"
        description="Entrez votre nouveau mot de passe ci-dessous"
    >
        <Head title="Réinitialiser le mot de passe" />

        <Form
            v-bind="update.form()"
            :transform="(data) => ({ ...data, token, email })"
            :reset-on-success="['password', 'password_confirmation']"
            v-slot="{ errors, processing }"
        >
            <div class="grid gap-5">
                <div class="grid gap-2">
                    <Label for="email" class="text-sm font-medium">Adresse email</Label>
                    <Input
                        id="email"
                        type="email"
                        name="email"
                        autocomplete="email"
                        v-model="inputEmail"
                        class="rounded-xl border-zinc-200 dark:border-zinc-700 bg-zinc-50 dark:bg-zinc-800 focus:ring-2 focus:ring-raosc-green/20 focus:border-raosc-green"
                        readonly
                    />
                    <InputError :message="errors.email" />
                </div>

                <div class="grid gap-2">
                    <Label for="password" class="text-sm font-medium">Nouveau mot de passe</Label>
                    <PasswordInput
                        id="password"
                        name="password"
                        autocomplete="new-password"
                        class="rounded-xl border-zinc-200 dark:border-zinc-700 bg-zinc-50 dark:bg-zinc-800 focus:ring-2 focus:ring-raosc-green/20 focus:border-raosc-green"
                        autofocus
                        placeholder="Créez un mot de passe sécurisé"
                    />
                    <InputError :message="errors.password" />
                </div>

                <div class="grid gap-2">
                    <Label for="password_confirmation" class="text-sm font-medium">
                        Confirmer le mot de passe
                    </Label>
                    <PasswordInput
                        id="password_confirmation"
                        name="password_confirmation"
                        autocomplete="new-password"
                        class="rounded-xl border-zinc-200 dark:border-zinc-700 bg-zinc-50 dark:bg-zinc-800 focus:ring-2 focus:ring-raosc-green/20 focus:border-raosc-green"
                        placeholder="Confirmez votre mot de passe"
                    />
                    <InputError :message="errors.password_confirmation" />
                </div>

                <Button
                    type="submit"
                    class="mt-2 w-full bg-raosc-green hover:bg-raosc-green/90 text-white font-semibold rounded-full py-2.5 shadow-sm transition-all"
                    :disabled="processing"
                    data-test="reset-password-button"
                >
                    <Spinner v-if="processing" />
                    Réinitialiser le mot de passe
                </Button>
            </div>
        </Form>
    </AuthLayout>
</template>