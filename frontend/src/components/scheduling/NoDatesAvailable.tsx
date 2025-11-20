import { Box, Typography, Button, Paper } from "@mui/material";
import EventBusyIcon from "@mui/icons-material/EventBusy";
import { useNavigate } from "react-router-dom";

export default function NoDatesAvailable() {
  const navigate = useNavigate();

  return (
    <Paper
      elevation={0}
      sx={{
        borderRadius: 2,
        border: "1px solid #eee",
        overflow: "hidden",
        width: "100%",
        maxWidth: 600,
        height: 400,
        mx: "auto",

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
        <Typography variant="h6">
          Agende o dia e horário da sua visita
        </Typography>
      </Box>

      {/* BODY */}
      <Box
        sx={{
          flexGrow: 1,
          p: 4,
          textAlign: "center",

          display: "flex",
          flexDirection: "column",
          justifyContent: "center",
          alignItems: "center",
        }}
      >
        <EventBusyIcon sx={{ fontSize: 70, color: "error.main", mb: 2 }} />

        <Typography variant="h6" fontWeight={600} sx={{ mb: 1 }}>
          Nenhuma data disponível
        </Typography>

        <Typography variant="body1" sx={{ color: "text.secondary" }}>
          No momento não há horários liberados para visitação deste veículo.
        </Typography>
      </Box>

      {/* FOOTER / BOTÃO */}
      <Box
        sx={{
          p: 3,
          borderTop: "1px solid #eee",
        }}
      >
        <Button
          variant="contained"
          sx={{
            background: "#ff123c",
            color: "#fff",
            fontWeight: 600,
            textTransform: "none",
            py: 1.5,
            width: "100%",
          }}
          onClick={() => navigate("/")}
        >
          Ver outros veículos
        </Button>
      </Box>
    </Paper>
  );
}
