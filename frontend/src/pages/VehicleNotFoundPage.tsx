import { Box, Typography, Button } from "@mui/material";
import ErrorOutlineIcon from "@mui/icons-material/ErrorOutline";
import { useNavigate } from "react-router-dom";
import Layout from "../components/layout/Layout";

export default function VehicleNotFound() {
    const navigate = useNavigate();
    const RED = "#ff123c";

    return (
        <Layout>
            <Box
                sx={{
                    borderRadius: 2,
                    border: "1px solid #eee",
                    overflow: "hidden",
                    maxWidth: 600,
                    margin: "50px auto",
                    textAlign: "center",
                    bgcolor: "#fff",
                }}
            >
                {/* HEADER */}
                <Box sx={{ background: "#2c2e3a", color: "#fff", py: 2 }}>
                    <Typography variant="h6">Veículo não encontrado</Typography>
                </Box>

                {/* CONTENT */}
                <Box sx={{ p: 4 }}>
                    <ErrorOutlineIcon sx={{ fontSize: 60, color: RED, mb: 1 }} />

                    <Typography variant="h6" fontWeight={600} sx={{ mb: 1 }}>
                        Não encontramos este veículo
                    </Typography>

                    <Typography
                        variant="body2"
                        sx={{ color: "text.secondary", maxWidth: 450, margin: "0 auto" }}
                    >
                        O veículo que você tentou acessar não está disponível ou pode ter sido removido da nossa base.
                    </Typography>
                </Box>

                {/* FOOTER */}
                <Box sx={{ borderTop: "1px solid #eee", p: 3 }}>
                    <Button
                        variant="contained"
                        fullWidth
                        sx={{
                            py: 1.5,
                            background: RED,
                            fontWeight: 600,
                            "&:hover": { background: "#e01030" },
                        }}
                        onClick={() => navigate("/")}
                    >
                        Ver outros veículos
                    </Button>
                </Box>
            </Box>
        </Layout>
    );
}
