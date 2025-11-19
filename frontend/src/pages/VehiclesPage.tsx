import Layout from "../components/layout/Layout";
import { useVehicles } from "../hooks/useVehicles";
import { Box } from "@mui/material";
import { VehicleCard } from "../components/vehicle/VehicleCard";
import type { Vehicle } from "../types/Vehicle";

export default function VehiclesPage() {
  const { data } = useVehicles();

  return (
    <Layout>
      <Box
        sx={{
          display: "grid",
          gridTemplateColumns: "repeat(auto-fill, minmax(250px, 1fr))",
          gap: 3,
          justifyItems: "center",
        }}
      >
        {data?.map((v: Vehicle) => (
          <VehicleCard key={v.id} {...v} />
        ))}
      </Box>
    </Layout>
  );
}
