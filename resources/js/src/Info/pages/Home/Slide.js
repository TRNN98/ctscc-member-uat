import React, { useEffect, useState } from "react";
import { Link } from "react-router-dom";
import OwlCarousel from "react-owl-carousel";

function Slide({ slide: Slide }) {
    // const [addCls,setCls] = useState();

    useEffect(() => {
        $(".slide-full  .owl-nav").addClass("container");
    }, [Slide]);

    const res_option = {
        responsive: {
            0: {
                nav: false
            },
            500: {
                nav: false
            },
            768: {
                nav: true
            }
        }
    };

    if (Slide) {
        return (
            <OwlCarousel
                className="slide-full owl-theme"
                items={1}
                loop
                center
                autoplaySpeed={300}
                dotsSpeed={400}
                autoplay
                autoplayHoverPause
                mergeFit={false}
                margin={10}
                nav
                navText={[
                    "<i class='fa fa-chevron-left'></i>",
                    "<i class='fa fa-chevron-right'></i>"
                ]}
                responsive={res_option.responsive}
            >
                {Slide.map((val, i) => (
                    <div className="item" key={i}>
                        <Link to={`/show/${val.No}`}>
                            <img
                                style={{ maxWidth: "100%", height: "100%" }}
                                src={`mediafiles/${val.nphoto}`}
                            />
                        </Link>
                    </div>
                ))}
            </OwlCarousel>
        );
    }
    return null;
}

export default Slide;
