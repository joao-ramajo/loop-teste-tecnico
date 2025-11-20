import AppBar from "@mui/material/AppBar";
import Toolbar from "@mui/material/Toolbar";
import Box from "@mui/material/Box";
import Typography from "@mui/material/Typography";
import { Link } from "react-router-dom";

import LoopLogo from "../../assets/loop-logo.svg";

import { Container } from "@mui/material";
import { useNavigate } from "react-router-dom";

export default function Navbar() {
    const navigate = useNavigate();

    return (
        <AppBar
            position="static"
            elevation={0}
            sx={{
                backgroundColor: "#fff",
                borderBottom: "1px solid #eee",
            }}
        >
            <Container maxWidth="xl">
                <Toolbar
                    disableGutters
                    sx={{
                        display: "flex",
                        justifyContent: "space-between",
                        alignItems: "center",
                        py: 2,
                    }}
                >
                    <Box sx={{ display: "flex", alignItems: "center", cursor: "pointer" }}>
                        <img
                            src={LoopLogo}
                            alt="Loop Logo"
                            style={{ height: 40 }}
                            onClick={() => navigate('/')}
                        />
                    </Box>
                    <Box sx={{ display: "flex", gap: 4 }}>
                        <Typography
                            component={Link}
                            to="#"
                            sx={{
                                textDecoration: "none",
                                color: "#3b3b3b",
                                fontSize: 16,
                                fontWeight: 500,
                            }}
                        >
                            Vender
                        </Typography>

                        <Typography
                            component={Link}
                            to="#"
                            sx={{
                                textDecoration: "none",
                                color: "#3b3b3b",
                                fontSize: 16,
                                fontWeight: 500,
                            }}
                        >
                            Comprar
                        </Typography>

                        <Typography
                            component={Link}
                            to="#"
                            sx={{
                                textDecoration: "none",
                                color: "#3b3b3b",
                                fontSize: 16,
                                fontWeight: 500,
                            }}
                        >
                            Lojas
                        </Typography>
                    </Box>
                </Toolbar>
            </Container>
        </AppBar>
    );
}
