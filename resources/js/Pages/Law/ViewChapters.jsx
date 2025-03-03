import React from "react";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import { Head, Link } from "@inertiajs/react";

function ViewChapters({ law, chapters }) {
    console.log(chapters);

    return (
        <AuthenticatedLayout
            header={
                <h2 className="text-xl font-semibold leading-tight text-gray-800">
                    Chapter - {law.title}
                </h2>
            }
        >
            <Head title="Laws" />
            <p className="font-bold text-xl mt-1">{}</p>
            <div className="max-w-screen-md mt-3 mx-auto px-4 text-black">
                {/* <button className="btn">Add Law</button> */}
                <div className="bg-white/95 card shadow-sm mb-2">
                    {chapters.map((chapter) => (
                        <Link
                            href={route("chapters.parts", chapter.id)}
                            className="p-3"
                            key={law.id}
                        >
                            <p className="font-bold text-xl">{chapter.title}</p>
                            <p className="text-sm">{chapter.description}</p>
                        </Link>
                    ))}
                </div>
            </div>
        </AuthenticatedLayout>
    );
}

export default ViewChapters;
