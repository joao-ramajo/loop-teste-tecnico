import { useState } from "react";
import { Box, Typography, TextField, Button } from "@mui/material";
import { IMaskInput } from "react-imask";
import { forwardRef } from "react";

interface MaskedInputProps {
    onChange: (event: { target: { name: string; value: string } }) => void;
    name: string;
}

export const PhoneMask = forwardRef<HTMLInputElement, MaskedInputProps>(
    function PhoneMask(props, ref) {
        const { onChange, ...other } = props;

        return (
            <IMaskInput
                {...other}
                mask="(00) 00000-0000"
                inputRef={ref as any}
                onAccept={(value: any) =>
                    onChange({ target: { name: props.name, value } })
                }
                overwrite
            />
        );
    }
);

interface UserInfoPanelProps {
    slotId: number;
    date: string;
    hour: string;
    error: string | null;
    onBack: () => void;
    onConfirm: (data: { name: string; email: string; phone: string }) => void;
}

export default function UserInfoPanel({
    // slotId,
    date,
    hour,
    error,
    // onBack,
    onConfirm,
}: UserInfoPanelProps) {
    const [form, setForm] = useState({
        name: "",
        email: "",
        phone: "",
    });

    const [errors, setErrors] = useState({
        name: "",
        email: "",
        phone: "",
    });

    const RED = "#ff123c";

    const validators = {
        name: (value: string) =>
            value.trim().length < 3 ? "Digite seu nome completo." : "",

        email: (value: string) =>
            /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value)
                ? ""
                : "Digite um e-mail válido.",

        phone: (value: string) =>
            /^\d{10,11}$/.test(value.replace(/\D/g, ""))
                ? ""
                : "Telefone inválido. Use 11 dígitos.",
    };

    const handleChange = (field: "name" | "email" | "phone", value: string) => {
        setForm((prev) => ({ ...prev, [field]: value }));

        setErrors((prev) => ({
            ...prev,
            [field]: validators[field](value),
        }));
    };

    function formatAppointment(date: string, hour: string) {
        const [year, month, day] = date.split("-").map(Number);

        const d = new Date(year, month - 1, day); // <-- Sempre no fuso local

        const weekday = d.toLocaleDateString("pt-BR", { weekday: "long" });
        const monthName = d.toLocaleDateString("pt-BR", { month: "long" });

        return `${capitalize(weekday)}, ${day} de ${monthName}, às ${hour} horas`;
    }

    function capitalize(str: string) {
        return str.charAt(0).toUpperCase() + str.slice(1);
    }

    const message = formatAppointment(date, hour);

    const isValid = !errors.name && !errors.email && !errors.phone &&
        form.name && form.email && form.phone;

    return (
        <Box
            sx={{
                borderRadius: 2,
                border: "1px solid #eee",
                overflow: "hidden",
                height: "400px",
                display: "flex",
                flexDirection: "column",
            }}
        >
            {/* HEADER */}
            <Box
                sx={{
                    background: "#2c2e3a",
                    color: "#fff",
                    textAlign: "center",
                    py: 2,
                }}
            >
                <Typography variant="subtitle1" sx={{ color: "#f5f5f5ff", fontWeight: 600 }}>Informações da Visita</Typography>
            </Box>

            {/* BODY */}
            <Box
                sx={{
                    p: 3,
                    flexGrow: 1,
                    display: "flex",
                    flexDirection: "column",
                    gap: 2,
                }}
            >
                <Typography
                    variant="body1"
                    sx={{ mb: 1, fontWeight: 600, textAlign: "center" }}
                >
                    { message }
                </Typography>

                {/* Nome */}
                <TextField
                    label="Nome completo"
                    fullWidth
                    value={form.name}
                    onChange={(e) => handleChange("name", e.target.value)}
                    error={Boolean(errors.name)}
                    helperText={errors.name}
                />

                {/* Email + Telefone */}
                <Box sx={{ display: "flex", gap: 2 }}>
                    <TextField
                        label="E-mail"
                        type="email"
                        sx={{ flex: 1 }}
                        value={form.email}
                        onChange={(e) => handleChange("email", e.target.value)}
                        error={Boolean(errors.email)}
                        helperText={errors.email}
                    />

                    <TextField
                        label="Telefone"
                        name="phone"
                        value={form.phone}
                        onChange={(e) => handleChange("phone", e.target.value)}
                        InputProps={{
                            inputComponent: PhoneMask as any,
                        }}
                        sx={{ flex: 1 }}
                        error={Boolean(errors.phone)}
                        helperText={errors.phone}
                    />
                </Box>

                {error && (
                    <Typography
                        variant="body2"
                        sx={{
                            color: "error.main",
                            mt: 1,
                            textAlign: "center",
                            fontWeight: 600,
                        }}
                    >
                        {error}
                    </Typography>
                )}
            </Box>

            {/* FOOTER */}
            <Box
                sx={{
                    p: 2,
                    borderTop: "1px solid #eee",
                    display: "flex",
                    gap: 2,
                }}
            >
                <Button
                    variant="contained"
                    fullWidth
                    disabled={!isValid}
                    sx={{
                        background: RED,
                        color: "#fff",
                        fontWeight: 600,
                    }}
                    onClick={() => onConfirm(form)}
                >
                    Confirmar
                </Button>
            </Box>
        </Box>
    );
}
