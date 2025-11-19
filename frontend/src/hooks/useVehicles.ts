import { useQuery } from "@tanstack/react-query";
import { api } from "../api/axios";
import type { Vehicle } from "../types/Vehicle";

export function useVehicles() {
  return useQuery<Vehicle[]>({
    queryKey: ["vehicles"],
    queryFn: async () => {
      const response = await api.get("/vehicles");
      return response.data.data;
    },
  });
}
