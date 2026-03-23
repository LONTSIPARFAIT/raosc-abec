<script setup lang="ts">
import { Form, Head } from '@inertiajs/vue3';
import { computed, ref } from 'vue';
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import {
    InputOTP,
    InputOTPGroup,
    InputOTPSlot,
} from '@/components/ui/input-otp';
import AuthLayout from '@/layouts/AuthLayout.vue';
import { store } from '@/routes/two-factor/login';
import type { TwoFactorConfigContent } from '@/types';

const authConfigContent = computed<TwoFactorConfigContent>(() => {
    if (showRecoveryInput.value) {
        return {
            title: 'Code de récupération',
            description:
                'Veuillez confirmer votre accès en entrant l’un de vos codes de récupération d’urgence.',
            buttonText: 'utiliser un code d’authentification',
        };
    }

    return {
        title: "Code d'authentification",
        description:
            "Entrez le code d'authentification fourni par votre application d'authentification.",
        buttonText: 'utiliser un code de récupération',
    };
});

const showRecoveryInput = ref<boolean>(false);

const toggleRecoveryMode = (clearErrors: () => void): void => {
    showRecoveryInput.value = !showRecoveryInput.value;
    clearErrors();
    code.value = '';
};

const code = ref<string>('');
</script>

<template>
    <AuthLayout
        :title="authConfigContent.title"
        :description="authConfigContent.description"
    >
        <Head title="Authentification à deux facteurs" />

        <div class="space-y-6">
            <template v-if="!showRecoveryInput">
                <Form
                    v-bind="store.form()"
                    class="space-y-5"
                    reset-on-error
                    @error="code = ''"
                    #default="{ errors, processing, clearErrors }"
                >
                    <input type="hidden" name="code" :value="code" />
                    <div
                        class="flex flex-col items-center justify-center space-y-3 text-center"
                    >
                        <div class="flex w-full items-center justify-center">
                            <InputOTP
                                id="otp"
                                v-model="code"
                                :maxlength="6"
                                :disabled="processing"
                                autofocus
                            >
                                <InputOTPGroup>
                                    <InputOTPSlot
                                        v-for="index in 6"
                                        :key="index"
                                        :index="index - 1"
                                        class="rounded-lg border-zinc-200 dark:border-zinc-700 bg-zinc-50 dark:bg-zinc-800 text-zinc-900 dark:text-white focus:ring-2 focus:ring-raosc-green/20"
                                    />
                                </InputOTPGroup>
                            </InputOTP>
                        </div>
                        <InputError :message="errors.code" />
                    </div>
                    <Button
                        type="submit"
                        class="w-full bg-raosc-green hover:bg-raosc-green/90 text-white font-semibold rounded-full py-2.5 shadow-sm transition-all"
                        :disabled="processing"
                    >
                        Continuer
                    </Button>
                    <div class="text-center text-sm text-zinc-500 dark:text-zinc-400">
                        <span>ou vous pouvez </span>
                        <button
                            type="button"
                            class="text-raosc-green font-semibold hover:text-raosc-green/80 transition-colors"
                            @click="() => toggleRecoveryMode(clearErrors)"
                        >
                            {{ authConfigContent.buttonText }}
                        </button>
                    </div>
                </Form>
            </template>

            <template v-else>
                <Form
                    v-bind="store.form()"
                    class="space-y-5"
                    reset-on-error
                    #default="{ errors, processing, clearErrors }"
                >
                    <div class="grid gap-2">
                        <Input
                            name="recovery_code"
                            type="text"
                            placeholder="Entrez votre code de récupération"
                            :autofocus="showRecoveryInput"
                            required
                            class="rounded-xl border-zinc-200 dark:border-zinc-700 bg-zinc-50 dark:bg-zinc-800 focus:ring-2 focus:ring-raosc-green/20 focus:border-raosc-green"
                        />
                        <InputError :message="errors.recovery_code" />
                    </div>
                    <Button
                        type="submit"
                        class="w-full bg-raosc-green hover:bg-raosc-green/90 text-white font-semibold rounded-full py-2.5 shadow-sm transition-all"
                        :disabled="processing"
                    >
                        Continuer
                    </Button>

                    <div class="text-center text-sm text-zinc-500 dark:text-zinc-400">
                        <span>ou vous pouvez </span>
                        <button
                            type="button"
                            class="text-raosc-green font-semibold hover:text-raosc-green/80 transition-colors"
                            @click="() => toggleRecoveryMode(clearErrors)"
                        >
                            {{ authConfigContent.buttonText }}
                        </button>
                    </div>
                </Form>
            </template>
        </div>
    </AuthLayout>
</template>