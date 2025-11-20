import { useState } from "react";
import { Box, Typography, Button } from "@mui/material";
import type { Slot } from "../../types/Slot";
import { useSlots } from "../../hooks/useSlots";
import NoDatesAvailable from "./NoDatesAvailable";
import ScheduleSkeleton from "../skeletons/ScheduleSkeleton";

interface SchedulePanelProps {
    vehicleId: number;
    onSelect: (data: {
        slotId: number;
        date: string;
        hour: string;
    }) => void;
}

export default function SchedulePanel({ vehicleId, onSelect }: SchedulePanelProps) {

    const { data: slots, isLoading } = useSlots(vehicleId);

    const [selectedDate, setSelectedDate] = useState<string | null>(null);
    const [selectedHour, setSelectedHour] = useState<string | null>(null);
    const [selectedSlotId, setSelectedSlotId] = useState<number | null>(null);

    // if (isLoading) return <Typography>Carregando datas...</Typography>;
    if (isLoading) return <ScheduleSkeleton></ScheduleSkeleton>;

    if (!slots?.length) {
        return <NoDatesAvailable />;
    }

    const groupedDates = slots.reduce((acc: Record<string, Slot[]>, slot: Slot) => {
        if (!acc[slot.date]) acc[slot.date] = [];
        acc[slot.date].push(slot);
        return acc;
    }, {});

    const allHours = [];
    for (let h = 9; h <= 18; h++) {
        allHours.push(`${String(h).padStart(2, "0")}:00`);
        if (h < 18) allHours.push(`${String(h).padStart(2, "0")}:30`);
    }

    const availableSlotsForDate: Slot[] =
        selectedDate ? groupedDates[selectedDate] ?? [] : [];

    const GREEN = "#4caf50";
    const RED = "#ff123c";

    const monthName = new Date(`${Object.keys(groupedDates)[0]}T00:00:00`)
        .toLocaleDateString("pt-BR", {
            month: "long",
            year: "numeric",
        });

    return (
        <>
            {/* CONTEÚDO PRINCIPAL */}
            <Box sx={{ borderRadius: 2, border: "1px solid #eee", overflow: "hidden", height: "400px", display: "flex", flexDirection: "column" }}>
                {/* HEADER */}
                <Box sx={{ background: "#2c2e3a", color: "#fff", textAlign: "center", py: 2 }}>
                    <Typography variant="h6">Agende o dia e horário da sua visita</Typography>
                </Box>

                {/* BODY */}
                <Box sx={{ p: 3, overflowY: "auto", flexGrow: 1 }}>
                    {/* Mês */}
                    <Typography variant="h6" sx={{ textAlign: "center", mb: 3 }}>
                        {monthName}
                    </Typography>

                    {/* Datas */}
                    <Box sx={{ display: "flex", gap: 1, mb: 3, justifyContent: "center", flexWrap: "wrap" }}>
                        {Object.keys(groupedDates).map((date) => {
                            const d = new Date(date);
                            const weekday = d.toLocaleDateString("pt-BR", { weekday: "short" })
                                .replace(".", "")
                                .toUpperCase();

                            const isSelected = selectedDate === date;

                            return (
                                <Box
                                    key={date}
                                    onClick={() => {
                                        setSelectedDate(date);
                                        setSelectedHour(null);
                                        setSelectedSlotId(null);
                                    }}
                                    sx={{
                                        width: 70,
                                        height: 70,
                                        borderRadius: "50%",
                                        background: isSelected ? GREEN : "#fafafa",
                                        color: isSelected ? "#fff" : "#000",
                                        border: "1px solid #ddd",
                                        display: "flex",
                                        flexDirection: "column",
                                        alignItems: "center",
                                        justifyContent: "center",
                                        cursor: "pointer",
                                    }}
                                >
                                    <span style={{ fontSize: 12 }}>{weekday}</span>
                                    <strong style={{ fontSize: 16 }}>{d.getDate()}</strong>
                                </Box>
                            );
                        })}
                    </Box>

                    {/* HORÁRIOS */}
                    <Box sx={{ display: "flex", gap: 1, flexWrap: "wrap", justifyContent: "center", mb: 2 }}>
                        {allHours.map((hour) => {
                            const slot = availableSlotsForDate.find((s) => s.hour === hour);
                            const isAvailable = selectedDate ? !!slot : false;
                            const isSelected = selectedHour === hour;

                            return (
                                <Box
                                    key={hour}
                                    onClick={() => {
                                        if (!isAvailable) return;
                                        setSelectedHour(hour);
                                        setSelectedSlotId(slot?.id ?? null);
                                    }}
                                    sx={{
                                        px: 3,
                                        py: 1,
                                        borderRadius: "20px",
                                        border: "1px solid #ddd",
                                        background: !isAvailable ? "#333" : isSelected ? GREEN : "#fafafa",
                                        color: !isAvailable ? "#999" : isSelected ? "#fff" : "#000",
                                        cursor: isAvailable ? "pointer" : "not-allowed",
                                        opacity: !isAvailable ? 0.4 : 1,
                                    }}
                                >
                                    {hour}
                                </Box>
                            );
                        })}
                    </Box>
                </Box>

                {/* FOOTER */}
                <Box sx={{ p: 2, borderTop: "1px solid #eee" }}>
                    <Button
                        variant="contained"
                        fullWidth
                        disabled={!selectedSlotId}
                        sx={{
                            py: 1.5,
                            background: RED,
                            color: "#fff",
                            fontWeight: 600,
                        }}
                        onClick={() => {
                            if (!selectedSlotId || !selectedDate || !selectedHour) return;

                            onSelect({
                                slotId: selectedSlotId,
                                date: selectedDate,
                                hour: selectedHour
                            });
                        }}
                    >
                        Continuar
                    </Button>
                </Box>
            </Box>
        </>
    );
}
