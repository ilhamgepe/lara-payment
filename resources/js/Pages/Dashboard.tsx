import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import { Head } from "@inertiajs/react";
import { PageProps } from "@/types";
import { Carousel } from "@mantine/carousel";
import { Button, Image, Text } from "@mantine/core";
import { useEffect, useRef } from "react";
import { notifications } from "@mantine/notifications";

export default function Dashboard({ auth, flash }: PageProps) {
    console.log(flash);

    useEffect(() => {
        if (flash.success) {
            notifications.show({
                title: "Success",
                message: flash.success,
                color: "green",
            });
        }
        if (flash.error) {
            notifications.show({
                title: "Failed",
                message: flash.error,
                color: "red",
            });
        }
    }, [flash]);
    return (
        <AuthenticatedLayout user={auth.user}>
            <Head title="Dashboard" />

            <div className="">
                <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div className="bg-white overflow-hidden shadow-sm sm:rounded-lg flex flex-col md:flex-row items-center justify-center gap-5 p-3">
                        <div>
                            <Carousel
                                maw={520}
                                miw={320}
                                mx="auto"
                                slideGap={"xl"}
                                height={300}
                                loop
                                draggable
                            >
                                <Carousel.Slide>
                                    <Image
                                        src={
                                            "https://images.unsplash.com/photo-1504674900247-0877df9cc836?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1170&q=80"
                                        }
                                    />
                                </Carousel.Slide>
                                <Carousel.Slide>
                                    <Image
                                        src={
                                            "https://images.unsplash.com/photo-1565299624946-b28f40a0ae38?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1170&q=80"
                                        }
                                    />
                                </Carousel.Slide>
                                <Carousel.Slide>
                                    <Image
                                        src={
                                            "https://images.unsplash.com/photo-1512621776951-a57141f2eefd?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1170&q=80"
                                        }
                                    />
                                </Carousel.Slide>
                            </Carousel>
                        </div>
                        <div className="flex items-center flex-col">
                            <Text size="xl" weight={500}>
                                Shop now!
                            </Text>
                            <Button component="a" href={route("createOrder")}>
                                Buy
                            </Button>
                        </div>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
