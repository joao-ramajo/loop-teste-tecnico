import Layout from "../components/layout/Layout";
import { Box, Button, Card, Stack, Typography } from "@mui/material";
import CheckCircleIcon from "@mui/icons-material/CheckCircle";
import { useNavigate } from "react-router-dom";
import { useLocation } from "react-router-dom";
import CalendarMonthIcon from "@mui/icons-material/CalendarMonth";
import LocationOnIcon from "@mui/icons-material/LocationOn";

export default function SuccessPage() {
    const navigate = useNavigate();
    const { state } = useLocation();

    const vehicle = state?.vehicle;
    const date = state?.date;
    const hour = state?.hour;

    console.log(vehicle);
    console.log(date);
    console.log(hour);

    function formatSchedule(date: string, hour: string): string {
        const dt = new Date(`${date}T${hour}`);

        const formatter = new Intl.DateTimeFormat("pt-BR", {
            weekday: "long",
            month: "long",
            day: "numeric",
        });

        const formatted = formatter.format(dt);

        return `${capitalize(formatted)} às ${hour}`;
    }

    function capitalize(str: string) {
        return str.charAt(0).toUpperCase() + str.slice(1);
    }

    const formattedDate = formatSchedule(date, hour);

    return (
        <Layout>

            <Card
                sx={{
                    width: "90%",
                    maxWidth: 1000,
                    p: 6,
                    textAlign: "center",
                    borderRadius: 3,
                    boxShadow: "0 4px 20px rgba(0,0,0,0.05)",
                }}
            >
                {/* Ícone */}
                <Box
                    sx={{
                        width: 120,
                        height: 120,
                        borderRadius: "50%",
                        mx: "auto",
                        mb: 3,
                        background: "linear-gradient(135deg, #ff8a9e, #ff2d55)",
                        display: "flex",
                        alignItems: "center",
                        justifyContent: "center",
                    }}
                >
                    <CheckCircleIcon sx={{ fontSize: 70, color: "white" }} />
                </Box>

                {/* Título */}
                <Typography variant="h5" fontWeight={600} mb={4}>
                    Agendamento concluído!
                </Typography>

                {/* Informações */}
                <Stack
                    spacing={2}
                    direction="row"
                    flexWrap="wrap"
                    justifyContent="center"
                    alignItems="center"
                    sx={{ color: "grey.700", mb: 4 }}
                >
                    <Stack direction="row" alignItems="center" spacing={1}>
                        <CalendarMonthIcon sx={{ fontSize: 22 }} />
                        <Typography>
                            {formattedDate}
                        </Typography>
                    </Stack>

                    <Typography sx={{ fontSize: 24, fontWeight: 300 }}>|</Typography>

                    <Stack direction="row" alignItems="center" spacing={1}>
                        <LocationOnIcon sx={{ fontSize: 22 }} />
                        <Typography>
                            {vehicle.location}
                        </Typography>
                    </Stack>
                </Stack>

                {/* Botão */}
                <Button
                    variant="contained"
                    color="error"
                    size="large"
                    sx={{
                        px: 4,
                        py: 1.5,
                        fontWeight: 600,
                        textTransform: "none",
                        borderRadius: 2,
                    }}
                    onClick={() => {
                        navigate('/')
                    }}
                >
                    Outros Veículos
                </Button>
            </Card>

        </Layout>
    );
}