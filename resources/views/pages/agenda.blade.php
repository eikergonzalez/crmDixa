@extends('layouts.backend')

@section('content')
    <div class="content">
        <div class="block block-rounded">
            <div class="block-header block-header-default">
                <h3 class="block-title">
                    Agenda
                </h3>
            </div>
            <div class="block-content">
                <div class="col-sm-6 col-xl-4 pb-5">
                    <button type="button" class="btn btn-secondary" onclick="addNewEvent()">Nuevo</button>
                </div>
                <div class="col-xl-12 bg-body-dark">
                    <div class="content">
                        <div class="block block-rounded">
                            <div class="block-content block-content-full">
                                <div id="calendario" class="p-xl-4"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="eventModal" tabindex="-1" role="dialog" aria-labelledby="modal-default-normal" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="label">Agregar evento</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="/agenda" method="post" autocomplete="off">
                    {{ csrf_field() }}
                    <div class="modal-body pb-5">
                        <input type="hidden" id="id" name="id" value="">
                        <div class="form-group">
                            <label for="age_titulo" class="col-form-label">Título</label>
                            <input type="text" class="form-control" id="age_titulo" name="age_titulo" required placeholder="Indique el título del evento">
                        </div>
                        <div class="form-group">
                            <label for="age_descri" class="col-form-label">Descripción</label>
                            <textarea class="form-control" id="age_descri" name="age_descri" rows="4" placeholder="Indique la descripción del evento"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="age_fecha" class="col-form-label">Fecha</label>
                            <input type="text" class="js-flatpickr form-control" id="age_fecha" name="age_fecha" placeholder="d/m/Y" data-date-format="d/m/Y">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <a type="button" class="btn btn-secondary text-light" data-bs-dismiss="modal" aria-label="Close">Cerrar</a>
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('js_after')
    <script>
        var agenda = {{ Js::from($agenda) }};
        $(document).ready(function() {
            flatpickr($('#age_fecha'), {
                "locale": "es"  // locale for this instance only
            });
            var calendarEl = document.getElementById('calendario');

            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                locale: 'es',
                themeSystem: "standard",
                /* eventDidMount: function(info) {
                    $(info.el).tooltip({ 
                        title: info.event.extendedProps.description,
                        placement: "top",
                        trigger: "hover",
                        container: "body"
                    });
                }, */
                events: _.map(agenda, function (item) {
                    return {
                        id : item.id,
                        title: item.age_titulo,
                        start : moment(item.age_fecha).format('YYYY-MM-DD'),
                        end:  moment(item.age_fecha).format('YYYY-MM-DD'),
                        description: item.age_descri,
                    }
                }),
                eventClick: function(info) {
                    editEvent(info.event.id);
                }
            });

            calendar.render();
        });

        function addNewEvent() {
            $('#id').val('');
            $('#age_titulo').val('');
            $('#age_descri').val('');
            $('#age_fecha').val('');
            $('#eventModal').modal('show');
        }

        function editEvent(id){
            let agendaFilter = _.find(agenda, function(o) { return o.id == id; });
            $('#label').html("Editar evento");
            $('#id').val(agendaFilter.id);
            $('#age_titulo').val(agendaFilter.age_titulo);
            $('#age_descri').val(agendaFilter.age_descri);
            $('#age_fecha').val(moment(agendaFilter.age_fecha).format('DD/MM/YYYY'));
            $('#eventModal').modal('show');
        }

        Dashmix.onLoad(class {
            static addEvent() {
                let e = document.querySelector(".js-add-event"),
                    t = "";
                document.querySelector(".js-form-add-event").addEventListener("submit", (a => {
                    if (a.preventDefault(), t = e.value, t) {
                        console.log('llega');
                        /* let a = document.getElementById("js-events"),
                            n = document.createElement("li"),
                            l = document.createElement("div");
                        l.classList.add("js-event"), l.classList.add("p-2"), l.classList.add("fs-sm"), l.classList.add("fw-medium"), l.classList.add("rounded"), l.classList.add("bg-info-light"), l.classList.add("text-info"), l.textContent = t, n.appendChild(l), a.insertBefore(n, a.firstChild), e.value = "" */
                    }
                }))
            }
            static initEvents() {
                new FullCalendar.Draggable(document.getElementById("js-events"), {
                    itemSelector: ".js-event",
                    eventData: function(e) {
                        return {
                            title: e.textContent,
                            backgroundColor: getComputedStyle(e).color,
                            borderColor: getComputedStyle(e).color
                        }
                    }
                })
            }
            static init() {
                this.addEvent(), this.initEvents()
            }
        }.init());

    </script>
@endsection