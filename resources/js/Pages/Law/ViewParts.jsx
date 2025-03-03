import React from "react";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import { Head, Link } from "@inertiajs/react";

function ViewParts({ law, chapter, parts }) {
    return (
        <AuthenticatedLayout
            header={
                <h2 className="text-xl font-semibold leading-tight text-gray-800">
                    <p>Law - {law.title}</p>
                    <p>Chapter - {chapter.title}</p>
                </h2>
            }
        >
            <Head title="Laws" />
            <p className="font-bold text-xl mt-1">{}</p>
            <div className="max-w-screen-md mt-3 mx-auto px-4 text-black">
                {parts.map((part) => (
                    <div className="bg-white/95 card shadow-sm mb-2">
                        <Link
                            href={route("parts.sections", part.id)}
                            className="p-3"
                            key={part.id}
                        >
                            <p className="font-bold text-xl">{part.title}</p>
                        </Link>
                    </div>
                ))}{" "}
            </div>
        </AuthenticatedLayout>
    );
}

export default ViewParts;
