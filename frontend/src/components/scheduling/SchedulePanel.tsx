import { useState, useRef } from "react";
import { Box, Typography, Button } from "@mui/material";
import { useSlots } from "../../hooks/useSlots";
import type { Slot } from "../../types/Slot";
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

type SlotsByDate = Record<string, Slot[]>;
type SlotsByMonth = Record<string, SlotsByDate>;

export default function SchedulePanel({ vehicleId, onSelect }: SchedulePanelProps) {
  const { data, isLoading } = useSlots(vehicleId);

  const slots: Slot[] = (data ?? []) as Slot[];

  const [selectedMonth, setSelectedMonth] = useState<string | null>(null);
  const [selectedDate, setSelectedDate] = useState<string | null>(null);
  const [selectedHour, setSelectedHour] = useState<string | null>(null);
  const [selectedSlotId, setSelectedSlotId] = useState<number | null>(null);

  const datesRef = useRef<HTMLDivElement | null>(null);
  const hoursRef = useRef<HTMLDivElement | null>(null);

  if (isLoading) return <ScheduleSkeleton/>;

  if (!slots?.length) {
    return <NoDatesAvailable/>;
  }

  // Agrupar slots por mês
  const groupedByMonth = slots.reduce<SlotsByMonth>((acc, slot) => {
    const [year, month] = slot.date.split("-");
    const monthKey = `${year}-${month}`;

    if (!acc[monthKey]) {
      acc[monthKey] = {};
    }

    if (!acc[monthKey][slot.date]) {
      acc[monthKey][slot.date] = [];
    }

    acc[monthKey][slot.date].push(slot);
    return acc;
  }, {});

  const sortedMonths = Object.keys(groupedByMonth).sort();

  const allHours: string[] = [];
  for (let h = 9; h <= 18; h++) {
    allHours.push(`${String(h).padStart(2, "0")}:00`);
    if (h < 18) allHours.push(`${String(h).padStart(2, "0")}:30`);
  }

  const availableSlotsForDate: Slot[] =
    selectedDate && selectedMonth
      ? groupedByMonth[selectedMonth]?.[selectedDate] ?? []
      : [];

  const GREEN = "#4caf50";
  const RED = "#ff123c";

  return (
    <Box sx={{ borderRadius: 2, border: "1px solid #eee", overflow: "hidden", height: "400px", display: "flex", flexDirection: "column" }}>
      {/* HEADER */}
      <Box sx={{ background: "#2c2e3a", color: "#fff", textAlign: "center", py: 2 }}>
        <Typography variant="subtitle1" sx={{ color: "#f5f5f5ff", fontWeight: 600 }}>Agende o dia e horário da sua visita</Typography>
      </Box>

      {/* BODY */}
      <Box sx={{ p: 3, overflowY: "auto", flexGrow: 1 }}>
        {/* ETAPA 1: Selecionar Mês */}
        <Box sx={{ mb: 4 }}>
          <Typography variant="subtitle2" sx={{ mb: 2, color: "#666", fontWeight: 600 }}>
            1. Selecione o mês
          </Typography>
          <Box sx={{ display: "flex", gap: 2, flexWrap: "wrap", justifyContent: "center" }}>
            {sortedMonths.map((monthKey) => {
              const [year, month] = monthKey.split("-");
              const date = new Date(parseInt(year), parseInt(month) - 1, 1);
              const monthName = date.toLocaleDateString("pt-BR", {
                month: "long",
                year: "numeric",
              });

              const isSelected = selectedMonth === monthKey;

              return (
                <Box
                  key={monthKey}
                  onClick={() => {
                    setSelectedMonth(monthKey);
                    setSelectedDate(null);
                    setSelectedHour(null);
                    setSelectedSlotId(null);

                    setTimeout(() => {
                      datesRef.current?.scrollIntoView({ behavior: "smooth", block: "start" });
                    }, 100);
                  }}
                  sx={{
                    px: 4,
                    py: 2,
                    borderRadius: "25px",
                    background: isSelected ? GREEN : "#fafafa",
                    color: isSelected ? "#fff" : "#000",
                    border: "1px solid #ddd",
                    cursor: "pointer",
                    fontWeight: 600,
                    textTransform: "capitalize",
                    transition: "all 0.2s",
                    "&:hover": {
                      background: isSelected ? GREEN : "#f0f0f0",
                    },
                  }}
                >
                  <Typography>{monthName}</Typography>
                </Box>
              );
            })}
          </Box>
        </Box>

        {/* ETAPA 2: Selecionar Data */}
        {selectedMonth && (
          <Box ref={datesRef} sx={{ mb: 4 }}>
            <Typography variant="subtitle2" sx={{ mb: 2, color: "#666", fontWeight: 600 }}>
              2. Selecione o dia
            </Typography>
            <Box sx={{ display: "flex", gap: 1, justifyContent: "center", flexWrap: "wrap" }}>
              {Object.keys(groupedByMonth[selectedMonth]).sort().map((date) => {
                const [year, month, day] = date.split("-").map(Number);
                const d = new Date(year, month - 1, day);

                const weekday = d
                  .toLocaleDateString("pt-BR", { weekday: "short" })
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

                      setTimeout(() => {
                        hoursRef.current?.scrollIntoView({ behavior: "smooth", block: "start" });
                      }, 100);
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
                      transition: "all 0.2s",
                      "&:hover": {
                        background: isSelected ? GREEN : "#f0f0f0",
                      },
                    }}
                  >
                    <Typography><span style={{ fontSize: 12 }}>{weekday}</span></Typography>
                    <Typography><strong style={{ fontSize: 16 }}>{day}</strong></Typography>
                  </Box>
                );
              })}
            </Box>
          </Box>
        )}

        {/* ETAPA 3: Selecionar Horário */}
        {selectedDate && (
          <Box ref={hoursRef}>
            <Typography variant="subtitle2" sx={{ mb: 2, color: "#666", fontWeight: 600 }}>
              3. Selecione o horário
            </Typography>
            <Box sx={{ display: "flex", gap: 1, flexWrap: "wrap", justifyContent: "center" }}>
              {allHours.map((hour) => {
                const slot = availableSlotsForDate.find((s) => s.hour === hour);
                const isAvailable = !!slot;
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
                      transition: "all 0.2s",
                      "&:hover": {
                        background: !isAvailable ? "#333" : isSelected ? GREEN : "#f0f0f0",
                      },
                    }}
                  >
                    <Typography>{hour}</Typography>
                  </Box>
                );
              })}
            </Box>
          </Box>
        )}
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
            "&:hover": {
              background: "#e01030",
            },
            "&:disabled": {
              background: "#ccc",
              color: "#666",
            },
          }}
          onClick={() => {
            if (!selectedSlotId || !selectedDate || !selectedHour) return;

            onSelect(
              {
                slotId: selectedSlotId,
                date: selectedDate,
                hour: selectedHour,
              }
            );
          }}
        >
          Continuar
        </Button>
      </Box>
    </Box>
  );
}