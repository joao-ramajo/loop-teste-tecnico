import {
    Card,
    CardContent,
    CardMedia,
    Typography,
    Box,
    Stack,
} from "@mui/material";
import PlaceIcon from "@mui/icons-material/Place";
import { Link } from "react-router-dom";
import type { Vehicle } from "../../types/Vehicle";
interface VehicleCardProps {
    vehicle: Vehicle;
}

export function VehicleCard({ vehicle }: VehicleCardProps) {
    const { id, image_url, brand, model, version, price, location } = vehicle;
    return (
        <Card
            component={Link}
            to={`/veiculo/${id}`}
            state={{
                vehicle: {
                    id,
                    image_url,
                    brand,
                    model,
                    version,
                    price,
                    location,
                },
            }}
            sx={{
                textDecoration: "none",
                borderRadius: 2,
                overflow: "hidden",
                border: "1px solid rgba(0,0,0,0.08)",
                boxShadow: "0px 2px 6px rgba(0,0,0,0.06)",
                transition: "0.2s ease",
                height: "100%",                          // ⭐ FIXA A ALTURA DO CARD
                display: "flex",
                flexDirection: "column",
                "&:hover": {
                    boxShadow: "0px 4px 12px rgba(0,0,0,0.12)",
                    transform: "translateY(-2px)",
                },
            }}
        >
            <Box
                sx={{
                    width: 270,
                    height: 180,            // <-- ALTURA FIXA PADRÃO
                    overflow: "hidden",
                }}
            >
                <CardMedia
                    component="img"
                    image={image_url}
                    alt={brand}
                    sx={{
                        width: "100%",
                        height: "100%",
                        objectFit: "cover",   // <-- CORTE PROFISSIONAL
                    }}
                />
            </Box>

            <CardContent
                sx={{
                    p: 2,
                    display: "flex",
                    flexDirection: "column",
                    flexGrow: 1,                         // Faz o conteúdo preencher o espaço restante
                }}
            >
                <Typography variant="h6" fontWeight={700}>
                    {brand} {model}
                </Typography>

                <Typography
                    variant="body2"
                    sx={{
                        color: "text.secondary",
                        textTransform: "uppercase",
                        lineHeight: 1.2,
                        mt: 0.5,
                        mb: 1,
                    }}
                >
                    {version}
                </Typography>

                <Typography variant="h6" sx={{ fontWeight: 700, mb: "auto" }}>
                    R$ {price.toLocaleString("pt-BR")}
                </Typography>

                <Stack direction="row" alignItems="center" spacing={0.5}>
                    <PlaceIcon sx={{ fontSize: 18, color: "text.secondary" }} />
                    <Typography variant="body2" color="text.secondary">
                        {location}
                    </Typography>
                </Stack>
            </CardContent>
        </Card>
    );
}
