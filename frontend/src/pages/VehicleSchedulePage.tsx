import { Box, Typography } from "@mui/material";
import { useLocation, useParams } from "react-router-dom";
import { useState } from "react";

import { VehicleCard } from "../components/vehicle/VehicleCard";
import SchedulePanel from "../components/scheduling/SchedulePanel";
import UserInfoPanel from "../components/scheduling/UserInfoPanel";
import VehicleNotFound from "./VehicleNotFoundPage";

import Layout from "../components/layout/Layout";
import { useNavigate } from "react-router-dom";
import { useAppointment } from "../hooks/useAppointment";

export default function VehicleSchedulePage() {
    const navigate = useNavigate();
    const { state } = useLocation();
    const { vehicle } = state ?? {};
    const { id } = useParams();

    const appointment = useAppointment();

    const [step, setStep] = useState<1 | 2 | 3>(1);
    const [formError, setFormError] = useState<string | null>(null);

    const [selected, setSelected] = useState<{
        slotId: number;
        date: string;
        hour: string;
    } | null>(null);

    if (!vehicle) {
        return <VehicleNotFound />;
    }

    return (
        <Layout>
            <Box sx={{ mt: 4, px: 4 }}>
                <Typography
                    variant="body1"
                    sx={{
                        mb: 3,
                        cursor: "pointer",
                        display: "flex",
                        alignItems: "center",
                        gap: 1,
                    }}
                    onClick={() => history.back()}
                >
                    &lt; Voltar
                </Typography>

                <Box
                    sx={{
                        display: "flex",
                        gap: 4,
                        alignItems: "flex-start",
                        flexWrap: "wrap",
                    }}
                >
                    {/* Card */}
                    <Box sx={{ flex: "0 0 260px", height: "400px" }}>
                        <VehicleCard vehicle={vehicle} />
                    </Box>

                    {/* Painel */}
                    <Box sx={{ flex: 1, minWidth: "500px" }}>

                        {/* STEP 1 — escolher data/hora */}
                        {step === 1 && (
                            <SchedulePanel
                                vehicleId={Number(id)}
                                onSelect={({ slotId, date, hour }) => {
                                    setSelected({ slotId, date, hour });
                                    setStep(2);
                                }}
                            />
                        )}

                        {/* STEP 2 — preencher dados */}
                        {step === 2 && selected && (
                            <UserInfoPanel
                                slotId={selected.slotId}
                                date={selected.date}
                                hour={selected.hour}
                                error={formError}
                                onBack={() => setStep(1)}
                                onConfirm={(form) => {
                                    setFormError(null);

                                    appointment.mutate(
                                        {
                                            slot_id: selected.slotId,
                                            name: form.name,
                                            email: form.email,
                                            phone: form.phone,
                                        },
                                        {
                                            onError: (err: any) => {
                                                const backend = err?.response?.data;

                                                if (backend?.error) {
                                                    setFormError(backend.error);
                                                    console.log(backend.error);
                                                    return;
                                                }

                                                if (backend?.message) {
                                                    setFormError(backend.message);
                                                    return;
                                                }

                                                setFormError("Erro ao enviar agendamento.");
                                            },

                                            onSuccess: () => {
                                                setFormError(null);
                                                navigate("/agendamento-realizado", {
                                                    state: {
                                                        vehicle: vehicle,
                                                        date: selected.date,
                                                        hour: selected.hour,
                                                    }
                                                });
                                            }
                                        }
                                    );
                                }}
                            />
                        )}
                    </Box>
                </Box>
            </Box>
        </Layout>
    );
}
